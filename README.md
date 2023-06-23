# SMILE

Système de gestion informatique pour la Mobilité Internationale en Ligne des Étudiants

## Divers liens utiles :

- https://developers.erasmuswithoutpaper.eu/  
- https://github.com/erasmus-without-paper/ewp-specs-mobility-flowcharts/tree/v0.5.0
- https://github.com/orgs/erasmus-without-paper/repositories?type=all
- https://wiki.uni-foundation.eu/display/DASH/OLA
- https://wiki.uni-foundation.eu/display/WELCOME/Knowledge+base+user+guide

# Build & Deploy

Application déployée localement avec Apache et basée sur les images officielles.

## Dépendances
- PHP: v8.0
- Laminas : 1.8.0

## Docker-compose

```
docker-compose -f docker-compose.yml up
```

## Manuellement
```

```

## Acéder à l'application via un navigateur 

### Local  
https://127.0.0.1:8443


---------------

### Build unicaen-php-image
```
git clone https://git.unicaen.fr/open-source/docker/unicaen-image.git  
```
```
cd unicaen-image  
```
Construire l'image associée à la bonne version de PHP en précisant le proxy unicaen :  
```
docker build --rm --build-arg PHP_VERSION=8.0 --build-arg http_proxy=http://proxy.unicaen.fr:3128 --build-arg https_proxy=http://proxy.unicaen.fr:3128 --build-arg no_proxy=*.unicaen.fr -f Dockerfile-8.x -t unicaen-dev-php8.0-apache .
```

Puis construire les composants :  
```
docker exec smile-container composer update
```

### Build & Run smile-app
```
docker-compose -f docker-compose.yml --build
```

## Commandes utiles devOps

### Build Smile Core

```
docker build -f ./Dockerfile_Smile_Core --build-arg PHP_VERSION=8.0 -t ucn-smile-core .
```

### Build Smile database  
```
docker build -f ./Dockerfile_Smile_Database -t ucn-smile-database .
```

### Tag image example  
```
docker tag ucn-smile-core ucn-smile-core:1.0.0-SNAPSHOT
```
  
## Run Images

### Create network
```
docker network create --driver bridge ucn-smile
```
### Run container with network and ENV VAR  

Database :  
```
docker run -p 5432:5432 -e POSTGRES_PASSWORD= -e POSTGRES_USER= -e POSTGRES_DB= --network ucn-smile --name ucn-smile-database -d ucn-smile-database
```
Smile Core :  
```
docker run -p 8080:80 -p 8443:443 --network ucn-smile --name ucn-smile-core -d ucn-smile-core
```

Puis construire les composants :  
```
docker exec smile-container composer update
```

