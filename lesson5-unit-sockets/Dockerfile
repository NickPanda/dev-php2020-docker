FROM php:7.3-fpm

RUN apt update && apt install -y \
    curl \
    wget \
    git \
    grep \
    libpq-dev \
    libz-dev \
    zip \ 
    unzip \
    && docker-php-ext-install sockets \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /var/www
