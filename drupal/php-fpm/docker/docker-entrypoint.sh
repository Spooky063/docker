#!/bin/sh
set -e

# first arg is `-f` or `--some-option`
if [ "${1#-}" != "$1" ]; then
	set -- php-fpm "$@"
fi

if [ "$1" = 'php-fpm' ]; then
  # The first time volumes are mounted, the project needs to be recreated
  if [ ! -f composer.json ]; then
    composer create-project drupal/drupal:$DRUPAL_VERSION /var/www/html
  fi

	chown -R www-data:www-data .
fi

exec docker-php-entrypoint "$@"
