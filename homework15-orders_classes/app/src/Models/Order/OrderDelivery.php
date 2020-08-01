<?php

namespace App\Models\Order;

use App\Application;
use App\DTO\DTO;
use App\Mappers\DeliveryMapper;

/**
 * Class OrderDelivery
 * @package App\Models\Order
 */
class OrderDelivery
{
    /**
     * Получим доставщика
     * @param int $delivery_id
     * @return DTO|null
     */
    public function getDelivery(int $delivery_id)
    {
        $delivery = (new DeliveryMapper(Application::$DB))->findOne(['id' => $delivery_id]);
        $className = "App\Models\Delivery\Delivery" . $delivery->getCode();
        $delivery = new $className();

        return $delivery;
    }
}
