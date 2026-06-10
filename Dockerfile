FROM php:8.2-apache

RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libpq-dev \
    libpng-dev \
    libzip-dev \
    zip \
    && docker-php-ext-install pdo_mysql mysqli gd zip

RUN a2enmod rewrite

COPY . /var/www/html/
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN composer install --no-dev

RUN chown -R www-data:www-data /var/www/html/runtime /var/www/html/web/assets
RUN chmod -R 755 /var/www/html/runtime /var/www/html/web/assets

EXPOSE 80
