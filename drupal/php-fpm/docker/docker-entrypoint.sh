#!/bin/sh
set -e

if [ "${1#-}" != "$1" ]; then
  set -- php-fpm "$@"
fi

if [ "$1" = 'php-fpm' ]; then
  if [ ! -f composer.json ]; then
    composer create-project drupal/drupal:$DRUPAL_VERSION /var/www/html
  fi

  chown -R www-data:www-data .
fi

exec docker-php-entrypoint "$@"
