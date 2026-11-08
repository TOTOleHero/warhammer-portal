# ---------- Stage 1 : build des assets (Webpack Encore) ----------
FROM node:20-alpine AS assets
WORKDIR /app

# Dependances d'abord (meilleur cache Docker)
COPY sources/package.json sources/yarn.lock ./
RUN yarn install --frozen-lockfile

# Sources front + config
COPY sources/webpack.config.js ./
COPY sources/assets ./assets

# Build de production -> /app/public/build
RUN yarn encore production

# ---------- Stage 2 : application PHP ----------
FROM php:8-apache

RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
    && php -r "if (hash_file('sha384', 'composer-setup.php') === 'c8b085408188070d5f52bcfe4ecfbee5f727afa458b2573b8eaaf77b3419b0bf2768dc67c86944da1544f06fa544fd47') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;" \
    && php composer-setup.php \
    && php -r "unlink('composer-setup.php');" \
    && chmod +x composer.phar \
    && mv composer.phar /usr/local/bin/composer

RUN apt -y update --fix-missing \
    && apt -y install git unzip libicu-dev

RUN docker-php-ext-install pdo pdo_mysql intl

# config PHP de production
RUN cp "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"
RUN { \
      echo 'display_errors = Off'; \
      echo 'display_startup_errors = Off'; \
      echo 'log_errors = On'; \
      echo 'error_log = /proc/self/fd/2'; \
      echo 'error_reporting = E_ALL & ~E_DEPRECATED & ~E_STRICT'; \
      echo 'memory_limit = 2048M'; \
    } > "$PHP_INI_DIR/conf.d/99-app.ini"
# FIN AJOUT

ENV APACHE_DOCUMENT_ROOT /var/www/html/public

RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf
RUN sed -ri -e 's!</VirtualHost>!<Directory ${APACHE_DOCUMENT_ROOT}>\nAllowOverride None\nRequire all granted\nFallbackResource /index.php\n</Directory>\n</VirtualHost>!g' /etc/apache2/sites-available/*.conf

RUN printf "PassEnv APP_ENV APP_DEBUG APP_SECRET DATABASE_URL MAILER_DSN TRUSTED_PROXIES\n" \
      > /etc/apache2/conf-available/symfony-env.conf \
    && a2enconf symfony-env


COPY sources /var/www/html

# Assets compiles (ecrase tout public/build existant, vide ou obsolete)
RUN mkdir -p /var/www/html/var/cache /var/www/html/var/log /var/www/html/public/build \
    && chown -R www-data:www-data /var/www/html/var /var/www/html/public/build
COPY --from=assets /app/public/build /var/www/html/public/build

RUN mkdir -p /var/www/html/var
RUN chmod -R 755 /var/www/html \
    && chmod -R 777 /var/www/html/var

ENV APP_ENV=prod
ENV APP_DEBUG=0
ENV COMPOSER_ALLOW_SUPERUSER=1
RUN composer install --no-interaction --no-dev --optimize-autoloader
