FROM  php:zts-alpine3.7

WORKDIR /var/www/html
COPY ./novosga /var/www/html

RUN chown -R www-data:www-data /var/www/html/ && chmod -R 755 /var/www/html/
# Habilitar o mod_rewrite do Apache
# RUN a2enmod rewrite  