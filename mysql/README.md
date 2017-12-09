# Docker MySQL

## Container MySQL

Le container se base sur l'image de base de [mysql](https://hub.docker.com/_/mysql/).

On utilise donc les variables d'environnements de l'image :
 * MYSQL_ROOT_PASSWORD

Utilisé pour le mot de passe root de l'image mysql.

 * MYSQL_DATABASE

Créer une base de données lors du premier montage de l'image.

 * MYSQL_USER

Création d'un utilisateur avec les droits sur la base de données créé préalablement.

 * MYSQL_PASSWORD

Création d'un mot de passe pour l'utilisateur créé préalablement.

## Image phpmyadmin

Un makefile a été créé pour le lancement du phpmyadmin en liaison avec le container mysql.  

### Prérequis

Avant de commencer, il faut connaître plusieurs informations ; le nom du container
ainsi que le network du container mysql.

Pour le nom du container associé à mysql, il est décrit dans le fichier `docker-compose.yml` sous la clé `container_name`.

```
[...]
    container_name: db
[...]
```

Pour le network du container, il suffit de lancer une simple commande.

```
docker inspect <mysql_container_name> -f "{{json .HostConfig.NetworkMode }}"
```

### PhpMyAdmin

Pour lancer phpmyadmin, on utilise plusieurs options :
 * rm : pour supprimer le container après sa coupure
 * link : pour lier le container mysql à phpmyadmin
 * net : pour lier le bon network à phpmyadmin afin d'éviter les problèmes (genre getaddrinfo failed)
 * p : choisir quelle port on occupe pour avoir le rendu graphique

```
docker run --rm --link <mysql_container_name>:db --net <network> -p <port_out>:80 phpmyadmin/phpmyadmin
```
