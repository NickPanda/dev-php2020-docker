<?php

declare(strict_types=1);

namespace App\Models\Order;

use App\Application;
use App\DTO\DTO;
use App\Mappers\OrderMapper;
use App\Mappers\ProductOrderMapper;

/**
 * Class Order
 * @package App\Models\Order
 */
class Order
{
    /**
     * @var DTO
     */
    public DTO $order;

    /**
     * @var array
     */
    public array $productOrder;

    /**
     * @param OrderBuilder $builder
     *
     * @return self
     * @throws \Exception
     */
    public function createOrder(OrderBuilder $builder): self
    {
        $this->order = (new OrderMapper(Application::$DB))->insert($builder->getOrder());

        foreach ($builder->getProductOrder() as $productOrder) {
            $productOrder->setOrderId($this->order->getId());
            $this->productOrder[] = (new ProductOrderMapper(Application::$DB))->insert($productOrder);
        }

        return $this;
    }

    /**
     * Распределение товары доставки по посылкам
     */
    public function inDelivery(): void
    {
        new OrderParcel($this);
    }
}
