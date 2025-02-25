FROM php:7.0.3-apache

# Definir o diretório de trabalho
WORKDIR /var/www/html

# Copiar os arquivos do projeto
COPY . /var/www/html/
COPY public/ /var/www/html/
COPY bootstrap.php /var/www/html/bootstrap.php  
COPY src/ /var/www/html/src/

# Ajustar permissões para evitar erro 403 (Forbidden)
RUN chown -R www-data:www-data /var/www/html/ && chmod -R 755 /var/www/html/

# Habilitar o mod_rewrite do Apache
RUN a2enmod rewrite
