FROM php:8.2-apache

# Install MySQL client and extensions
RUN apt-get update && apt-get install -y mariadb-client \
    && docker-php-ext-install mysqli pdo pdo_mysql

# Copy project files
COPY . /var/www/html/

EXPOSE 80
