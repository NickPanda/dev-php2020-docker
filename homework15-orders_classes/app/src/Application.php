<?php

declare(strict_types=1);

namespace App;

use Dotenv\Dotenv;
use App\Interfaces\DB;
use App\DataBase\DBMySQL;
use App\Mappers\ClientMapper;
use App\Models\Order\OrderBuilder;
use App\Models\Order\Order;
use RuntimeException;

/**
 * Class Application
 * @package App
 */
class Application
{
    /**
     * @var DB|null
     */
    public static ?DB $DB = null;

    public function __construct()
    {
        $this->checkEnvFileAvailability();

        (Dotenv::createImmutable(dirname(__DIR__), '/.env'))->load();

        $this->validateDataEnv();

        self::getDb();
    }

    /**
     * Необходимые параметры окружения
     * @var array
     */
    private array $dataEnvNeeds = [
        'MYSQL_HOST',
        'MYSQL_PORT',
        'MYSQL_USER',
        'MYSQL_PASSWORD',
        'MYSQL_DB',
    ];

    /**
     * @throws \Exception
     */
    public function run(): void
    {
        // Загрузка клиента
        $client = (new ClientMapper(Application::$DB))->findOne(['id' => 1]);

        $builder = new OrderBuilder($client);

        $builder->addProduct(1, 12)
            ->addProduct(2, 10)
            ->addProduct(3, 5)
            ->setDelivery(2)
            ->setDiscount(1)
            ->calculate();

        // Запись заказ в БД.
        $order = (new Order())->createOrder($builder);

        // Передача товара в доставку
        // В зависимости от доставщика сортируем товар по посылкам
        $order->inDelivery();
        $msg = 'Заказ #' . $order->order->getId() . ' на сумму ' . $order->order->getSum() . ' добавлен!';
        Message::writeOutput($msg);
    }

    /**
     * @return DB
     */
    public function getDb(): DB
    {
        self::$DB = (new DBMySQL())->connect();

        return self::$DB;
    }

    /**
     * Проверка наличия файла .env
     */
    private function checkEnvFileAvailability(): void
    {
        if (!file_exists(dirname(__DIR__) . '/.env')) {
            throw new \RuntimeException('Отсутствует файл окружения .env.');
        }
    }

    /**
     * Проверка параметров окружения (.env)
     */
    private function validateDataEnv(): void
    {
        if (empty($this->dataEnvNeeds)) {
            return;
        }

        foreach ($this->dataEnvNeeds as $dataEnvNeed) {
            if (!getenv($dataEnvNeed)) {
                throw new RuntimeException('Нет необходимых параметров окружения из env file "' . $dataEnvNeed . '"');
            }
        }
    }
}
