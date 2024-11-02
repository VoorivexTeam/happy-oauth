# Use the official PHP image with Apache
FROM php:8.0-apache

# Enable Apache rewrite module
RUN a2enmod rewrite

# Allow .htaccess overrides
RUN sed -i 's/AllowOverride None/AllowOverride All/g' /etc/apache2/apache2.conf

# Enable PHP short tags in php.ini
RUN echo "short_open_tag=On" > /usr/local/etc/php/conf.d/short-tags.ini

# Create the directory and set permissions
RUN mkdir -p /var/www/html/db && chmod 777 /var/www/html/db