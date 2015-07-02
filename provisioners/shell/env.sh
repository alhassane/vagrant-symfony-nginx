#!/bin/sh

# export INSTALL_USERNAME=$(ps -o user= -p $$ | awk '{print $1}')
export INSTALL_USERNAME="vagrant"
export INSTALL_USERGROUP="www-data"
export INSTALL_USERHOME="/home/vagrant"
export SERVER="lemp" # lemp|lamp

#
declare -A plateforms
i=1

# we declare the first appplication
declare -A plateform1=(
    ["PLATEFORM_INSTALL_NAME"]="sfynx-nginx"
    ["PLATEFORM_INSTALL_TYPE"]=""
    ["PLATEFORM_INSTALL_VERSION"]=""
    ["PLATEFORM_PROJET_NAME"]="sfynx"
    ["PLATEFORM_PROJET_GIT"]=""
    ["DOMAINE"]=""
    ["MYAPP_BUNDLE_NAME"]=""
    ["MYAPP_PREFIX"]=""
    ["FOSUSER_PREFIX"]=""
)
for key in "${!plateform1[@]}"; do
  plateforms[$i,$key]=${plateform1[$key]}
done

# we declare the second appplication
declare -A plateform2=(
    ["PLATEFORM_INSTALL_NAME"]="nbi-nginx"
    ["PLATEFORM_INSTALL_TYPE"]=""
    ["PLATEFORM_INSTALL_VERSION"]=""
    ["PLATEFORM_PROJET_NAME"]="nosbelidees"
    ["PLATEFORM_PROJET_GIT"]=""
    ["DOMAINE"]=""
    ["MYAPP_BUNDLE_NAME"]=""
    ["MYAPP_PREFIX"]=""
    ["FOSUSER_PREFIX"]=""
)
((i++))
for key in "${!plateform2[@]}"; do
  plateforms[$i,$key]=${plateform2[$key]}
done

# we declare the third appplication
declare -A plateform3=(
    ["PLATEFORM_INSTALL_NAME"]="symfony-nginx"
    ["PLATEFORM_INSTALL_TYPE"]="composer"
    ["PLATEFORM_INSTALL_VERSION"]="2.4.0"
    ["PLATEFORM_PROJET_NAME"]="symfony24"
    ["PLATEFORM_PROJET_GIT"]=""
    ["DOMAINE"]="Dirisi"
    ["MYAPP_BUNDLE_NAME"]="Website"
    ["MYAPP_PREFIX"]="dirisi"
    ["FOSUSER_PREFIX"]="$MYAPP_PREFIX/admin"
)
((i++))
for key in "${!plateform3[@]}"; do
  plateforms[$i,$key]=${plateform3[$key]}
done

# we declare the fourth appplication
declare -A plateform4=(
    ["PLATEFORM_INSTALL_NAME"]="symfony-nginx"
    ["PLATEFORM_INSTALL_TYPE"]="composer"
    ["PLATEFORM_INSTALL_VERSION"]="2.7.0"
    ["PLATEFORM_PROJET_NAME"]="symfony27"
    ["PLATEFORM_PROJET_GIT"]=""
    ["DOMAINE"]="Dirisi"
    ["MYAPP_BUNDLE_NAME"]="Website"
    ["MYAPP_PREFIX"]="dirisi"
    ["FOSUSER_PREFIX"]="$MYAPP_PREFIX/admin"
)
((i++))
for key in "${!plateform4[@]}"; do
  plateforms[$i,$key]=${plateform4[$key]}
done
