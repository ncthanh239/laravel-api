# Set master image
FROM php:7.4-fpm

# Set working directory
WORKDIR /var/www/html

# Install PHP Composer
RUN apt-get update && apt-get install -y libzip-dev

# Extension zip for laravel
RUN docker-php-ext-install zip 

# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN composer global require laravel/installer

RUN apt-get update && apt-get install -y libzip-dev

# Extension mysql driver for mysql
RUN docker-php-ext-install pdo_mysql mysqli

# Copy existing application directory permissions
COPY --chown=www-data:www-data . .
