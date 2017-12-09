# Wp-cli

Wp-cli est un éxecutable qui n'a pas lieu d'être au sein d'un docker-compose
ou d'un container vu qu'il n'est pas différent selon les projets.  
On va donc utiliser l'image `wordpress:cli` pour éxecuter nos commandes.

Pour lancer une commande, on utilise plusieurs options :
 * rm : pour supprimer le container après sa coupure
 * name : pour lui donner un nom reconnaissable lors du listing
 * user : pour donner certains droits à l'utilisateur qui éxecute la commande
 * net : pour lier le bon network à wp-cli afin d'avoir la connexion à la BDD
 * env-file : pour donner les variables définies dans le fichier `wp-config.php` (si existant)
 * v : pour lier le dossier root de wordpress à wp-cli

```bash
docker run --rm \
  --name wpcli \
  --user $(id -u):$(id -g) \
  --net <network> \
  --env-file <file> \
  -v <drupal_volume_workdir>:/var/html/www \
  wordpress:cli <command>
```
