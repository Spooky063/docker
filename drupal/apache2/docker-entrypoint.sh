#!/bin/bash
set -e

# IF FPM DOCUMENT ROOT IS DEFINED CHANGE IT
if [ -n "$FPM_DOCUMENT_ROOT" ]; then
    echo "Change fpm document root as ${FPM_DOCUMENT_ROOT}\$1"
    sed -i "s|/var/www/html/|$FPM_DOCUMENT_ROOT|g" /usr/local/apache2/conf/extra/vhost.conf
fi

exec "$@"