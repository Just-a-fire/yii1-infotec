ARG PHP_VERSION

FROM php:$PHP_VERSION

RUN apt-get update && apt-get install -y \
    bash \
    nano \
    git \
    zip \
    unzip \
    && docker-php-ext-install pdo pdo_mysql

# если уже есть установленная версия, которая может быть не совместима с текущей версией PHP, то она пересоберется без подтверждения через prompt
RUN pecl install xdebug --output --force xdebug \ 
    && docker-php-ext-enable xdebug

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

RUN chown -R www-data:www-data /var/www