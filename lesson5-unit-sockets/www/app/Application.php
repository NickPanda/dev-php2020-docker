<?php

namespace App;

use Dotenv\Dotenv;
use Exception;

/**
 * Класс Application
 * 
 * @package App
 */
class Application
{

    const TYPE_CLIENT = 'client';
    const TYPE_SERVER = 'server';

    /**
     * @return void
     * 
     * @throws Exception|RuntimeException
     */
    public function run(): void
    { 
        if(!$this->checkArgType()) {
            throw new Exception('Отсутствует аргумент "-t'.self::TYPE_CLIENT.'" или "-t'.self::TYPE_SERVER.'');
        }

        if (!file_exists(dirname(__DIR__) . '/.env')) {
            throw new \RuntimeException('Отсутствует файл окружения .env.');
        }

        (Dotenv::createImmutable(dirname(__DIR__) , '/.env'))->load();

        if(!getenv('FILE_PATH_SOCKET_SERVER')) {
            throw new Exception('В файле .env отсутствует "FILE_PATH_SOCKET_SERVER".');
        }

        if(!getenv('FILE_PATH_SOCKET_CLIENT')) {
            throw new Exception('В файле .env отсутствует "FILE_PATH_SOCKET_CLIENT".');
        }

        if (!extension_loaded('sockets')) {
            throw new Exception('Расширение "sockets" не загружено.');
        }

        switch($this->getType()) {
            case self::TYPE_CLIENT:
                (new Client())->run();
            break;
            case self::TYPE_SERVER:
                (new Server())->run();
            break;
        }

    }

    /**
     * Проверка типа аргумента.
     * 
     * @return bool
     */
    private function checkArgType(): bool
    {
        if($_SERVER['argc'] < 2) {
            return false;
        }
        $options = $this->getOptions();
        if(empty($options['t'])) {
            return false;
        }
        if(($options['t'] !== self::TYPE_CLIENT) && ($options['t'] !== self::TYPE_SERVER)) {
            return false;
        }

        return true;

    }

    /**
     * Получение типа сокета.
     * клиент/сервер
     * 
     * @return string
     */
    private function getType(): string
    {
        $options = $this->getOptions();

        switch($options['t']) {
            case self::TYPE_CLIENT:
                $type = self::TYPE_CLIENT;
            break;
            case self::TYPE_SERVER:
                $type = self::TYPE_SERVER;
            break;
            default:
                $type = '';
            break;
        }
    
        return $type;
    }

    /**
     * Получение аргументов командной строки.
     * 
     * @return array
     */
    private function getOptions(): array
    {
        return getopt('t:');
    }
}
