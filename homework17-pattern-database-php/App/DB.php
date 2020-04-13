<?php

namespace App;

use Dotenv\Dotenv;

/**
 * Класс DB
 * 
 * @package App
 */
class DB {
    public static function getDbh() {
        $DSN = '';
        $DSN .= getenv('DB_DRIVER').':';
        $DSN .= 'host='.getenv('DB_HOST').';';
        $DSN .= 'port='.getenv('DB_PORT').';';
        $DSN .= 'dbname='.getenv('DB_NAME').';';
        $DSN .= 'user='.getenv('DB_USER').';';
        $DSN .= 'password='.getenv('DB_PASSWORD');

        return new \PDO($DSN);
    }
}
