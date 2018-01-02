FROM httpd:2.4
MAINTAINER Periscope <contact@periscopemail.com>

RUN set -ex; \
    \
    apt-get -yqq update; \
    apt-get -yqq install \
    vim \
    ; \
    apt-get clean

# ACTIVATE mod_rewrite, fast_cgi & proxy
RUN set -ex; \
    sed -i "s/#LoadModule rewrite_module/LoadModule rewrite_module/g" /usr/local/apache2/conf/httpd.conf; \
    sed -i "s/#LoadModule proxy_module/LoadModule proxy_module/g" /usr/local/apache2/conf/httpd.conf; \
    sed -i "s/#LoadModule proxy_http_module/LoadModule proxy_http_module/g" /usr/local/apache2/conf/httpd.conf; \
    sed -i "s/#LoadModule proxy_fcgi_module/LoadModule proxy_fcgi_module/g" /usr/local/apache2/conf/httpd.conf

# Include our configuration
RUN set -ex; \
    echo "Include conf/extra/vhost.conf" >> /usr/local/apache2/conf/httpd.conf

# Include our vhost with php-fpm
COPY vhost.conf /usr/local/apache2/conf/extra/vhost.conf

# Change entrypoint
COPY docker-entrypoint.sh /sbin/docker-entrypoint.sh
RUN set -ex; \
    chmod +x /sbin/docker-entrypoint.sh

# Change entrypoint
ENTRYPOINT ["/bin/bash", "/sbin/docker-entrypoint.sh"]
CMD ["httpd-foreground"]