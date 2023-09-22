#!/bin/bash

# Configuration des informations du dépôt source
SOURCE_REPO_URL="https://github.com/EsupPortail/esup-smile.git"
SOURCE_REPO_BRANCH="main"

# Configuration des informations du dépôt de destination
DEST_REPO_URL="https://github.com/EsupPortail/esup-smile.git"
DEST_REPO_BRANCH="main"

# Nom d'utilisateur et token d'accès pour l'authentification (le cas échéant)
USERNAME=""
ACCESS_TOKEN=""

# Cloner le dépôt source
git clone $SOURCE_REPO_URL source_repo
cd source_repo

# Créer une branche temporaire (optionnel)
git checkout -b temp_branch

# Copier les fichiers du dépôt source vers le dépôt de destination
cp -r * ../destination_repo/

# Accéder au dépôt de destination
cd ../destination_repo

# Configurer l'authentification (si nécessaire)
if [ -n "$USERNAME" ] && [ -n "$ACCESS_TOKEN" ]; then
  git config user.name "$USERNAME"
  git config user.email "votre-email@example.com"
  git remote add origin $DEST_REPO_URL
  git config credential.helper "store --file=.git/credentials"
  echo -e "username=$USERNAME\npassword=$ACCESS_TOKEN" > .git/credentials
fi

# Ajouter, valider et pousser les changements vers le dépôt de destination
git add .
git commit -m "Déployer du dépôt source"
git push origin $DEST_REPO_BRANCH

# Supprimer le répertoire temporaire du dépôt source
cd ..
rm -rf source_repo

# Terminer
echo "Déploiement terminé avec succès."