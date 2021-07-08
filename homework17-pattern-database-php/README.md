# ДЗ 17 - Паттерны БД

## Установка

- выполнить `composer install`
- добавить таблицу Movies (согласно DDL из прошлых ДЗ)
- создать и заполнить файл .env конфигурацией к БД

## Работа с БД

### Полный список фильмов
php index.php -p list

### Один фильм
php index.php -p item --id 1

### Добавить фильм
php index.php -p add

### Обновить фильм
php index.php -p edit --id 1

### Удалить фильм
php index.php -p delete --id 1
