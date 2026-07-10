#!/bin/sh

set -eu

mkdir -p \
    /var/www/html/writable/cache \
    /var/www/html/writable/debugbar \
    /var/www/html/writable/logs \
    /var/www/html/writable/session \
    /var/www/html/writable/uploads

chown -R www-data:www-data /var/www/html/writable 2>/dev/null || true
chmod -R 775 /var/www/html/writable 2>/dev/null || true

composer install \
    --no-dev \
    --no-interaction \
    --prefer-dist \
    --optimize-autoloader

exec "$@"