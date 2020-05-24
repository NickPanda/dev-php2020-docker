FROM php:7.3-fpm

RUN apt update && apt install -y \
    git \
    curl \
    wget \
    zip \ 
    unzip \
    libz-dev \
	libmemcached-dev \
	libcurl4-openssl-dev \
	pkg-config \
	libssl-dev \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
    && pecl install xdebug mongodb raphf propro redis \
	&& docker-php-ext-enable xdebug mongodb raphf propro redis \
	&& pecl install pecl_http \
	&& docker-php-ext-enable http

WORKDIR /var/www
