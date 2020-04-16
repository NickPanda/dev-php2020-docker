<?php

namespace App;

use Dotenv\Dotenv;

/**
 * Класс Config
 * 
 * @package App
 */
class Config {

    /**
     * Инициализация PHP Errors
     */
    public static function initPhpErrors() {
        $errRep = getenv('E_ALL') ?: 'E_ALL';
        $dispErr = getenv('DISP_ERR') ?: 1;
        $dispStartErr = getenv('DISP_START_ERR') ?: 1;

        ini_set('error_reporting', $errRep);
        ini_set('display_errors', $dispErr);
        ini_set('display_startup_errors', $dispStartErr);
    }

    public static function checkEnv() {
       if (!file_exists(dirname(__DIR__) . '/.env')) {
            throw new \RuntimeException('Отсутствует файл окружения .env.');
        }

        (Dotenv::createImmutable(dirname(__DIR__) , '/.env'))->load();

        if(!getenv('DB_DRIVER')) {
            throw new \Exception('В файле .env отсутствует "DB_DRIVER".');
        }

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
}
