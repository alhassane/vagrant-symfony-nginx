<?php

namespace Dirisi\WebsiteBundle\Controller;

use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Dirisi\WebsiteBundle\Entity\Acteur;
use Dirisi\WebsiteBundle\Form\ActeurForm;
use Dirisi\WebsiteBundle\Form\ActeurRechercheForm;

class ActeurController extends ContainerAware
{
    public function listerAction()
    {
        $em = $this->container->get('doctrine')->getEntityManager();
        $acteurs= $em->getRepository('DirisiWebsiteBundle:Acteur')->findAll();

		$form = $this->container->get('form.factory')->create(new ActeurRechercheForm());

        return $this->container->get('templating')->renderResponse('DirisiWebsiteBundle:Acteur:lister.html.twig', array(
            'acteurs' => $acteurs,
	    'form' => $form->createView()	    
        ));
    }

    public function topAction($max = 5)
    {
        $em = $this->container->get('doctrine')->getEntityManager();

        $qb = $em->createQueryBuilder();
        $qb->select('a')
          ->from('DirisiWebsiteBundle:Acteur', 'a')
          ->orderBy('a.dateNaissance', 'DESC')
          ->setMaxResults($max);

        $query = $qb->getQuery();
        $acteurs = $query->getResult();

        return $this->container->get('templating')->renderResponse('DirisiWebsiteBundle:Acteur:liste.html.twig', array(
            'acteurs' => $acteurs,
        ));
    }

    public function rechercherAction()
    {               
        $request = $this->container->get('request');

        if($request->isXmlHttpRequest())
        {
            $motcle = '';
            $motcle = $request->request->get('motcle');

            $em = $this->container->get('doctrine')->getEntityManager();

            if($motcle != '')
            {
                $qb = $em->createQueryBuilder();

                $qb->select('a')
                  ->from('DirisiWebsiteBundle:Acteur', 'a')
                  ->where("a.nom LIKE :motcle OR a.prenom LIKE :motcle")
                  ->orderBy('a.nom', 'ASC')
                  ->setParameter('motcle', '%'.$motcle.'%');

                $query = $qb->getQuery();
                $acteurs = $query->getResult();
            }
            else {
                $acteurs = $em->getRepository('DirisiWebsiteBundle:Acteur')->findAll();
            }

            return $this->container->get('templating')->renderResponse('DirisiWebsiteBundle:Acteur:liste.html.twig', array(
                'acteurs' => $acteurs
                ));
        }
	else {
	    return $this->listerAction();
	}
    }
    
    public function editerAction($id = null)
    {
        $message='';
        $em = $this->container->get('doctrine')->getEntityManager();

        if (isset($id)) 
        {
            // modification d’un acteur existant : on recherche ses données
            $acteur = $em->find('DirisiWebsiteBundle:Acteur', $id);

            if (!$acteur)
            {
                $message='Aucun acteur trouvé';
            }
        }
        else 
        {
            // ajout d’un nouvel acteur
            $acteur = new Acteur();
        }

        $form = $this->container->get('form.factory')->create(new ActeurForm(), $acteur);

        $request = $this->container->get('request');

        if ($request->getMethod() == 'POST') 
        {
            $form->bind($request);

            if ($form->isValid()) 
            {
                $em->persist($acteur);
                $em->flush();
                if (isset($id)) 
                {
                    $message = $this->container->get('translator')->trans('acteur.modifier.succes',array(
                                '%nom%' => $acteur->getNom(),
                                '%prenom%' => $acteur->getPrenom()
                                ));
                }
                else 
                {
                    $message = $this->container->get('translator')->trans('acteur.ajouter.succes',array(
                                '%nom%' => $acteur->getNom(),
                                '%prenom%' => $acteur->getPrenom()
                                ));
                }
            }
        }

        return $this->container->get('templating')->renderResponse(
        'DirisiWebsiteBundle:Acteur:editer.html.twig',
            array(
            'form' => $form->createView(),
            'message' => $message,
            'acteur' => $acteur
            )
        );
    }

    public function supprimerAction($id)
    {
        $em = $this->container->get('doctrine')->getEntityManager();
        $acteur = $em->find('DirisiWebsiteBundle:Acteur', $id);

        if (!$acteur) 
        {
            throw new NotFoundHttpException("Acteur non trouvé");
        }

        $em->remove($acteur);
        $em->flush();        


        return new RedirectResponse($this->container->get('router')->generate('dirisi_acteur_lister'));
    }
}