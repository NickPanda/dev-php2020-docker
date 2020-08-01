<?php

declare(strict_types=1);

namespace App\Mappers;

use App\DTO\DTO;
use App\DTO\Order;

/**
 * Class OrderMapper
 * @package App\Mappers
 */
class OrderMapper extends Mapper
{
    /**
     * @var string
     */
    protected string $collectName = 'orders';

    /**
     * @return Order
     */
    protected static function getDTO(): Order
    {
        return new Order();
    }

    /**
     * @param array|DTO $data
     * @return DTO
     * @throws \Exception
     */
    public function insert($data): DTO
    {
        $model = is_array($data) ? new Order($data) : $data;

        if (!$model->getClientId() || !$model->getSum()) {
            throw new \Exception('Свойства заказа не заданы!');
        }

        $id = $this->connect->insert(
            $this->collectName,
            [
                'client_id' => $model->getClientId(),
                'sum' => $model->getSum(),
                'status' => $model->getStatus(),
                'delivery_id' => $model->getDeliveryId(),
            ]
        );

        $model->setId($id);

        return $model;
    }
}
