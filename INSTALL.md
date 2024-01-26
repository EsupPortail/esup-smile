# Installation et déploiement

Application déployée localement avec Nginx et basée sur les images officielles de php.

## Dépendances
- PHP: v8.2
- Laminas : 1.8.0

## Configuration
Merci de renseigner les différentes variables d'environnement.  
Dupliquer le fichier ./.env_example en ./.env

Et renseigner à minima les valeurs suivantes tout en gardant les autres valeurs à vides :    
```
DB_HOST=smile-database
DB_NAME=
DB_PORT=
DB_USER=
DB_PSWD=
```

Suivant les variables que vous avez configuré dans le fichier descriptif ./docker-compose.yaml  

# Au cas où xdebug n'est pas désactivé

Commenter la ligne suivante dans /docker-compose.yaml avec un # dans la déclaration du smile-core : 

```
#- ./deploy_configuration/php/xdebug.ini:/usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
```

# Si vous avez un proxy
Générer le fichier ./deploy_configuration/.env_proxy
ajouter les lignes :  
```
http_proxy=http://your_proxy:PORT
https_proxy=http://your_proxy:PORT
```
Le script ./deploy_configuration/proxy.sh se chargera de configurer les variables dans les conteneurs.  
Si vous n'avez pas de proxy, ne pas générer le fichier .env_proxy.

# Génération de la base de démonstration

Effectuer la commande suivante à la racine du projet (linux/macos) :  

```
cp ./deploy_configuration/demo-smile-esup.sql ./deploy_configuration/db
```

Autrement dit copier/coller ce fichier dans le répertoire décrit plus haut.  

## Docker-compose
Démarrer les services associés à SMILE :  

```
docker-compose -f docker-compose.yaml up
```

Attendez la génération de la base de données (un message LOG:  database system is ready to accept connections ).

# Acéder à l'application via un navigateur 

## Local  
http://localhost:8080