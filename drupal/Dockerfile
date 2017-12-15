FROM php:7.0-fpm

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

RUN { \
    echo 'file_uploads=On'; \
    echo 'max_input_time=300'; \
    echo 'max_input_vars=5000'; \
    echo 'max_execution_time=180'; \
    echo 'upload_max_filesize=24M'; \
    echo 'post_max_size=24M'; \
    echo 'memory_limit=64M'; \
} > /usr/local/etc/php/conf.d/00-drupal-recommended.ini

WORKDIR /var/www/html

ENV DRUPAL_VERSION 8.4.0

RUN set -ex; \
    curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN set -ex; \
    composer create-project drupal/drupal:${DRUPAL_VERSION} /var/www/html; \
    chown -R www-data:www-data /var/www/html

CMD ["php-fpm"]
