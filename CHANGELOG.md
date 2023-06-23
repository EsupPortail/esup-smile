# CHANGELOG

## 3.2.1

- Mise à jour des dépendances.
- Ajout de `post-install-cmd` et de `post-create-project-cmd` utiles dans le `composer.json`.

## 3.2.0

- Simplification des configs pour Docker.

## 3.1.0

- Dépendance avec les versions 3.0 des bib unicaen.
- Version avec une bdd postgres dans un service docker.
- Création du fichier de licence LICENSE.
- Création du script install.sh pour mimer ce qui est fait dans sygal.
- Nouvelle façon de mettre le numéro de version dans la config (cf. bin/bump-version).

## 3.0.0

- Dépendances: montée possible en ZF 3.
- Création d'un module démo avec bdd sqlite minimale.
- Docker: modif des ports utilisés et passage à PHP 7.3.
- Config pour tests unitaires.
- Désactivation du validateur de session HttpUserAgent car peut provoquer une erreur 'Session validation failed' sur android.



## 1.0.1

- Mise à jour des dépendances avec Composer.
- Ajout de la colonne user_role.accessible_exterieur pour gérer le blocages de rôles depuis l'extérieur.

## 1.0.0

- Embryon d'application.
