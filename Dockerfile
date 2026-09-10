FROM php:8.2-apache

# Instalamos la extensión pdo_mysql que necesita tu archivo de Conexión
RUN docker-php-ext-install pdo pdo_mysql

COPY . /var/www/html/
EXPOSE 80
