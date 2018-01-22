# Docker MySQL

## Container MySQL

Le container se base sur l'image de base de [mysql](https://hub.docker.com/_/mysql/).

Pour pouvoir se connecter on donne un mot de passe au superutilisateur `root`.  
Pour faire ceci, on ajoute dans la partie `environment` du fichier `docker-compose.yml`
la variable `MYSQL_ROOT_PASSWORD` avec la valeur choisi.

On va aussi pouvoir passer nos variables de configuration au travers de la partie
`volumes` du `docker-compose.yml`.  
Un autre volume est déclaré : `mysql`. Celui-ci va nous permettre de persister
les informations de notre container. Tant qu'il n'est pas supprimé, les données
restent récupérable.

Pour lancer le container, c'est très simple.
```bash
docker-compose up
```

## Images supplémentaires

Un makefile a été créé pour le lancement de PhpMyAdmin ou Adminer.  
Vu qu'on utilise docker-compose, il va falloir récupérer le réseau pour pouvoir
faire la liaison entre le containeur `mysql` et les images.

### Prérequis

Avant de commencer, il faut connaître plusieurs informations ; le nom du container
ainsi que le network du container mysql.

Pour le nom du container associé à mysql, c'est simple.
Il est décrit dans le fichier `docker-compose.yml` sous la clé `container_name`.

```
[...]
    container_name: mysql
[...]
```

Pour le network du container, il suffit de lancer une simple commande.
drupal
```bash
docker inspect <mysql_container_name> -f "{{json .HostConfig.NetworkMode }}"

docker inspect -f "{{json .HostConfig.NetworkMode }}" $(docker-compose ps -q <mysql_container_name>)
```

### Préalable

Avant tout, il faut lancer le container mysql.

```bash
docker-compose up
```

 > Si un problème intervient comme un conflit sur le nom du container, il suffit de supprimer le container.  
 Vu qu'un volume est monté sur l'image aucune données ne sera perdu.

### PhpMyAdmin

Pour lancer PhpMyAdmin, on utilise plusieurs options :
 * rm : pour supprimer le container après sa coupure
 * name : pour lui donner un nom reconnaissable lors du listing
 * link : pour lier le container mysql à l'alias `db` de l'image phpmyadmin
 * net : pour lier le bon network à phpmyadmin afin d'éviter les problèmes (getaddrinfo failed)
 * p : choisir quelle port on lie au port `80` de l'image phpmyadmin

```bash
docker run --rm --name pma --link <mysql_container_name>:db --net <network> -p <port_out>:80 phpmyadmin/phpmyadmin
```

Pour lancer la commande et avoir l'outil phpmyadmin.
```bash
make pma
```
Il suffit ensuite de se rendre sur votre navigateur et de taper : http://localhost:<port_out>.  
Vous pourrez ensuite vous connecter avec les identifiants présent dans le fichier
`docker-compose.yml`.

### Adminer

Pour lancer Adminer, on utilise plusieurs options :
 * rm : pour supprimer le container après sa coupure
 * name : pour lui donner un nom reconnaissable lors du listing
 * link : pour lier le container mysql à l'alias `db` de l'image adminer
 * net : pour lier le bon network à adminer afin d'éviter les problèmes (getaddrinfo failed)
 * p : choisir quelle port on lie au port `8080` de l'image adminer

```bash
docker run --rm --name adminer --link <mysql_container_name>:db --net <network> -p <port_out>:8080 adminer
```

Pour lancer la commande et avoir l'outil adminer.
```bash
make adminer
```
Il suffit ensuite de se rendre sur votre navigateur et de taper : http://localhost:<port_out>.  
Vous pourrez ensuite vous connecter avec les identifiants présent dans le fichier
`docker-compose.yml`.

## Manipulations

### Backup
```bash
docker exec mysql /usr/bin/mysqldump -u <user> --password=<password> -r <database> | Set-Content backup.sql
```

### Restore
```bash
cat backup.sql | docker exec -i mysql /usr/bin/mysql -u <user> --password=<password> <database>
```

### Size
Liste la taille de chacune des base de données
```
SELECT table_schema AS "Database", SUM(data_length + index_length) / 1024 / 1024 AS "Size (MB)" FROM information_schema.TABLES GROUP BY table_schema;
```

Liste les tables d'une base de données selon leur taille
```
SELECT table_schema as Database, table_name AS Table, round(((data_length + index_length) / 1024 / 1024), 2) Size in MB FROM information_schema.TABLES WHERE table_schema = '<database>' ORDER BY (data_length + index_length) DESC;
```
