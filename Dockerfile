FROM php:7.2-apache

COPY application /var/www/tnial
COPY assets /var/www/tnial
COPY doc /var/www/tnial
COPY images /var/www/tnial
COPY system /var/www/tnial
COPY token /var/www/tnial
COPY upload /var/www/tnial
COPY .editorconfig /var/www/tnial
COPY .htaccess /var/www/tnial
COPY application /var/www/tnial
COPY composer.json /var/www/tnial
COPY contributing.md /var/www/tnial
COPY credentials.json /var/www/tnial
COPY index.php /var/www/tnial
COPY license.txt /var/www/tnial
COPY quickstart.php /var/www/tnial
COPY readme.rst /var/www/tnial
COPY token.json /var/www/tnial

RUN a2enmod rewrite
RUN docker-php-ext-install pdo_mysql
RUN a2enconf docker-ci-php
RUN chown -R www-data:www-data /var/www