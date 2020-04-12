<?php

namespace App;

use Dotenv\Dotenv;

class Config {

    public static function checkEnv() {
       if (!file_exists(dirname(__DIR__) . '/.env')) {
            throw new \RuntimeException('Отсутствует файл окружения .env.');
        }

        (Dotenv::createImmutable(dirname(__DIR__) , '/.env'))->load();

        if(!getenv('DB_HOST')) {
            throw new \Exception('В файле .env отсутствует "DB_HOST".');
        }

        if(!getenv('DB_PORT')) {
            throw new \Exception('В файле .env отсутствует "DB_PORT".');
        }

        if(!getenv('DB_NAME')) {
            throw new \Exception('В файле .env отсутствует "DB_NAME".');
        }

        if(!getenv('DB_USER')) {
            throw new \Exception('В файле .env отсутствует "DB_USER".');
        }

        if(!getenv('DB_PASSWORD')) {
            throw new \Exception('В файле .env отсутствует "DB_PASSWORD".');
        }        
    }

    public static function getDbh() {
        self::checkEnv();
        $DSN = 'pgsql:';
        $DSN .= 'host='.getenv('DB_HOST').';';
        $DSN .= 'port='.getenv('DB_PORT').';';
        $DSN .= 'dbname='.getenv('DB_NAME').';';
        $DSN .= 'user='.getenv('DB_USER').';';
        $DSN .= 'password='.getenv('DB_PASSWORD');

        return new \PDO($DSN);
    }
}
