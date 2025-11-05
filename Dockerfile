# Use official PHP image with Apache
FROM php:8.2-apache

# Install PostgreSQL extension
RUN apt-get update && \
    apt-get install -y libpq-dev && \
    docker-php-ext-install pdo_pgsql pgsql

# Copy your project into the container
COPY . /var/www/html/

# Enable Apache mod_rewrite (optional)
RUN a2enmod rewrite
