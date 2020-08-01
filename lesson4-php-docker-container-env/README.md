# Контейнер к уроку 4. С расширениями и утилитами

За основу взят образ с https://hub.docker.com/_/php/

## Список утилит:
- git
- curl
- grep
- wget
- autoconf
- build-base
- libmemcached-dev
- libcurl
- zlib-dev
- php-pear
- php-pgsql
- composer

## Список расширений
- memcached
- redis 
- propro 
- raphf

## Сборка контейнера

`cd current/path`
`docker build -t lesson4_php:v1 .`
`docker run -d --rm --name lesson4_php_cont -it lesson4_php:v1`
