FROM php:7-apache-bullseye


RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
    && php -r "if (hash_file('sha384', 'composer-setup.php') === 'dac665fdc30fdd8ec78b38b9800061b4150413ff2e3b6f88543c636f7cd84f6db9189d43a81e5503cda447da73c7e5b6') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;" \
    && php composer-setup.php \
    && php -r "unlink('composer-setup.php');" \
    && chmod +x composer.phar \
    && mv composer.phar /usr/local/bin/composer

RUN apt -y update \
    && apt -y install git unzip  libicu-dev

RUN docker-php-ext-install pdo pdo_mysql intl

ENV APACHE_DOCUMENT_ROOT /var/www/html/public

RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf
RUN sed -ri -e 's!</VirtualHost>!<Directory ${APACHE_DOCUMENT_ROOT}>\nAllowOverride None\nRequire all granted\nFallbackResource /index.php\n</Directory>\n</VirtualHost>!g' /etc/apache2/sites-available/*.conf
RUN echo 'memory_limit = 2048M' >> /usr/local/etc/php/conf.d/docker-php-memlimit.ini;

COPY sources /var/www/html
RUN chmod -R 755 /var/www/html /var/www/html/var
RUN chmod +X /var/www/html /var/www/html/var
RUN chmod -R 777 /var/www/html/var

ENV COMPOSER_ALLOW_SUPERUSER 1
RUN composer install --no-interaction
