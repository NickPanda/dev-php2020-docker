<?php

namespace App;

use Exception;
use Dotenv\Dotenv;

use App\Route;

/**
 * Класс Application
 * 
 * @package App
 */
class Application
{

    /**
     * Необходимые параметры окружения.
     * 
     * @var array
     */
    private $dataEnvNeeds = [
        'YOUTUBE_API_KEY',
        'MONGO_HOST',
        'MONGO_USERNAME',
        'MONGO_PASSWORD',
        'MONGO_PORT',
        'MONGO_DATABASE',
    ];

    /**
     * @return void
     */
    public function run(): void
    { 

        $this->checkEnvFileAvailability();

        (Dotenv::createImmutable(dirname(__DIR__) , '/.env'))->load();

        $this->validateDataEnv();

        $router = new Route();
        $router->init();
    }

    /**
     * Проверка наличия файла .env.
     */
    private function checkEnvFileAvailability() {
        if (!file_exists(dirname(__DIR__) . '/.env')) {
            throw new \RuntimeException('Отсутствует файл окружения .env.');
        }
    }

    /**
     * Проверка параметров окружения (.env).
     */
    private function validateDataEnv()
    {
        if (empty($this->dataEnvNeeds)) {
            return;
        }

        foreach ($this->dataEnvNeeds as $dataEnvNeed) {
            if (!getenv($dataEnvNeed)) {
                throw new RuntimeException('missing from the env file "'.$dataEnvNeed.'"');
            }
        }
    }
}
