FROM composer:1.5
FROM php:7.1-fpm

RUN set -ex; \
    \
    buildDeps=' \
        libjpeg62-turbo-dev \
        libpng12-dev \
        libpq-dev \
    '; \
    apt-get update && apt-get install -y --no-install-recommends $buildDeps && rm -rf /var/lib/apt/lists/* \
    ; \
    docker-php-ext-configure gd \
        --with-jpeg-dir=/usr \
        --with-png-dir=/usr \
    ; \
    docker-php-ext-install -j "$(nproc)" gd opcache mbstring pdo pdo_mysql pdo_pgsql zip \
    ; \
    apt-mark manual \
        libjpeg62-turbo \
        libpq5 \
    ; \
    apt-get purge -y --auto-remove $buildDeps

COPY conf.d/opcache-recommanded.ini /usr/local/etc/php/opcache-recommanded.ini
COPY conf.d/drupal-recommanded.ini /usr/local/etc/php/drupal-recommanded.ini
COPY --from=0 /usr/bin/composer /usr/bin/composer
COPY docker/docker-entrypoint.sh /usr/local/bin/docker-entrypoint

WORKDIR /var/www/html
ENTRYPOINT ["docker-entrypoint"]
CMD ["php-fpm"]

ENV COMPOSER_ALLOW_SUPERUSER 1
ARG DRUPAL_VERSION=8.4.0
ENV DRUPAL_VERSION ${DRUPAL_VERSION}

RUN composer global require "hirak/prestissimo:^0.3" --prefer-dist --no-progress --no-suggest --optimize-autoloader --classmap-authoritative  --no-interaction

RUN composer create-project drupal/drupal:$DRUPAL_VERSION . --prefer-dist --no-progress

RUN chown -R www-data .
