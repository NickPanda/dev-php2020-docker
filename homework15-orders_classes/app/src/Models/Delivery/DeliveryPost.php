<?php

declare(strict_types=1);

namespace App\Models\Delivery;

use App\Interfaces\Delivery;
use App\Models\Order\OrderBuilder;

/**
 * Class DeliveryPost
 * @package App\Models\Delivery
 */
class DeliveryPost implements Delivery
{
    /**
     * @var int $sum
     */
    protected int $sum = 0;

    /**
     * Расчет цены доставки
     * @param OrderBuilder $builder
     * @return bool
     */
    public function calculate(OrderBuilder $builder): bool
    {
        // Считаем стоимость доставки
        $this->sum = 40;

        return true;
    }

    /**
     * Возвращает сумму доставки
     * @return int
     */
    public function getSum(): int
    {
        return $this->sum;
    }
}
