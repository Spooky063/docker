<p align="center"><img src="https://docker-curriculum.com/images/logo.png" width="300"></p>

## A propos de Docker
Docker est un logiciel libre qui automatise le déploiement d'applications dans des conteneurs logiciels

## Commandes

### Containers

#### Lister
Voir la liste des containers qui tourne actuellement
```bash
docker ps
```

Voir la liste de tous les containers installés
```bash
docker ps -a
```

#### Inspecter
Inspecter un container
```bash
docker inspect <container_name>

docker inspect $(docker-compose ps -q <container>)
```

Récupérer une valeur spécifique du container
```bash
docker inspect -f "{{json .HostConfig.NetworkMode }}" $(docker-compose ps -q <container>)

docker inspect -f "{{json .HostConfig.NetworkMode }}" $(docker-compose ps -q <container>) | python -m json.tool
```

#### Lancement
Lancer un container
```bash
docker start <container_name>
```

#### Arrêt
Arrêter un container
```bash
docker stop <container_name>

docker stop $(docker-compose ps -q <container>)
```

Arrêter tous les containers
```bash
docker stop $(docker ps -a -q)
```

#### Suppression
Supprimer un container
```bash
docker rm <container_id>
```

Supprimer tous les containers
```bash
docker rm $(docker ps -a -q)
```

### Images

#### Téléchargement
Télécharger/Mettre à jour une image
```bash
docker pull <image_name>
```

#### Lister
Voir la liste de toutes les images téléchargées
```bash
docker ps
```

#### Suppression
Supprimer une image
```bash
docker rmi <image_id>
```

Supprimer toutes les images téléchargées
```bash
docker rmi $(docker images -q)
```

### Autres

#### Purger
Purge tous les containers stoppés :
 - tous les volumes non utilisés par au moins 1 container
 - tous les réseaux non utilisés par au moins 1 cotnainer
 - toutes les images inutiles

```bash
docker system prune
```

#### Importer du contenu vers un container
```bash
docker cp <container_id>:</file/path/within/container> </host/path/target>
```

#### Exporter le contenu d'un container
```bash
docker run --rm --volumes-from <container_name> -v $(pwd):/backup busybox tar czf /backup/${PWD##*/}_$(date +'%Y%m%d').tar.gz <container_path_to_extract>

docker run --rm --volumes-from $(docker-compose ps -q <container>) -v $(pwd):/backup busybox tar czf /backup/${PWD##*/}_$(date +'%Y%m%d').tar.gz <container_path_to_extract>
```
