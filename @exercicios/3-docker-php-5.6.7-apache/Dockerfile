FROM php:5.6.7-apache

WORKDIR /var/www/html
COPY . /var/www/html/novosga

RUN chown -R www-data:www-data /var/www/html/ && chmod -R 755 /var/www/html/
# Habilitar o mod_rewrite do Apache
RUN a2enmod rewrite  