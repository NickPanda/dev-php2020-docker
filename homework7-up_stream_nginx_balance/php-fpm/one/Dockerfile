FROM php:7.1-fpm

RUN apt update && apt install -y \
    git \
    curl \
    wget \
    zip \ 
    unzip \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /var/www
