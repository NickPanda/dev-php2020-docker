# Homework 6. Контейнеры nginx+php_fpm

## Контейнеры
- nginx
- php_fpm

## Конфигурация nginx
Файлы конфигурации находятся `nginx/conf.d`
- laravel.conf (host: laravel/)
- brackets.conf (host: brackets/)


### brackets/ Валидация скобок
Для работы потребуется:
- зайти в контейнер php_fpm
- перейти в директорию /var/ww/brackets
- запустить composer install
- после можно будет отправлять POST запрос на brackets/ (потребуется прописать в hosts)

### laravel/ Базовая установка laravel 7
Установка не содержит vendor, потребуется выполнить composer install