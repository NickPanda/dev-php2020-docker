FROM php:7.3-fpm

RUN apt update && apt install -y \
    git \
    curl \
    wget \
    # libpq-dev \
    # libz-dev \
    zip \ 
    unzip
#&&
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /var/www