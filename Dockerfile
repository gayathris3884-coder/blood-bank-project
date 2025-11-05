# Use the latest PHP with Apache
FROM php:8.2-apache

# Copy project files
COPY . /var/www/html/

# Install required PHP extensions
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Expose port 80
EXPOSE 80
