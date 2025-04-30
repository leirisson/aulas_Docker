FROM  php:5.6-apache

# Habilita o módulo do Apache
RUN a2enmod rewrite

# Configura o Apache para servir arquivos PHP
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf

# Define a pasta do Apache
WORKDIR /var/www/html

# Cria um arquivo phpinfo.php para teste
RUN echo "<?php phpinfo(); ?>" > /var/www/html/phpinfo.php

# Expõe a porta do Apache
EXPOSE 80

# Comando de inicialização do container
CMD ["apachectl", "-D", "FOREGROUND"]
