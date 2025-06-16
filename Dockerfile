# Use the official PHP image with Apache and mysqli extension
FROM php:8.0-apache

# Install mysqli extension
RUN docker-php-ext-install mysqli \
    && docker-php-ext-install pdo pdo_mysql \
    && docker-php-ext-enable pdo_mysql

# Copy application source code to the Apache document root
COPY . /var/www/html/

# Expose port 80 for web traffic
EXPOSE 80

# Enable Apache mod_rewrite (if needed for the app)
RUN a2enmod rewrite

# Set file permissions (optional, depending on app requirements)
RUN chown -R www-data:www-data /var/www/html

# Start Apache in the foreground
CMD ["apache2-foreground"]
