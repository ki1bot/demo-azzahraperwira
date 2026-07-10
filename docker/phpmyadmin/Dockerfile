FROM phpmyadmin:5.2.3-apache

USER root

RUN set -eux; \
    apt-get update; \
    apt-get install -y --no-install-recommends \
        ca-certificates \
        curl \
        unzip; \
    curl -fsSL \
        "https://files.phpmyadmin.net/themes/blueberry/1.1.0/blueberry-1.1.0.zip" \
        -o /tmp/blueberry-1.1.0.zip; \
    mkdir -p /tmp/blueberry-extract; \
    unzip -q \
        /tmp/blueberry-1.1.0.zip \
        -d /tmp/blueberry-extract; \
    theme_directory="$(dirname "$(find /tmp/blueberry-extract -type f -name theme.json -print -quit)")"; \
    test -n "$theme_directory"; \
    rm -rf /var/www/html/themes/blueberry; \
    mkdir -p /var/www/html/themes/blueberry; \
    cp -a "$theme_directory"/. /var/www/html/themes/blueberry/; \
    chown -R www-data:www-data /var/www/html/themes/blueberry; \
    find /var/www/html/themes/blueberry -type d -exec chmod 555 {} \;; \
    find /var/www/html/themes/blueberry -type f -exec chmod 444 {} \;; \
    rm -rf \
        /tmp/blueberry-1.1.0.zip \
        /tmp/blueberry-extract \
        /var/lib/apt/lists/*

COPY --chown=www-data:www-data \
    config.user.inc.php \
    /etc/phpmyadmin/config.user.inc.php