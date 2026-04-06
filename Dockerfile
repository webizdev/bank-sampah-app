FROM php:8.2-apache

# Enable Apache mod_rewrite (often needed for routing)
RUN a2enmod rewrite

# Install required PHP extensions for MySQL connection
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Set the working directory
WORKDIR /var/www/html
