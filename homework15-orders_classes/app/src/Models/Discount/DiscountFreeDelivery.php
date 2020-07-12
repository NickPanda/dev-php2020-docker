<?php

declare(strict_types=1);

namespace App\Models\Discount;

use App\Interfaces\Discount;
use App\Models\Order\OrderBuilder;

/**
 * Class DiscountFreeDelivery
 * @package App\Models\Discount
 */
class DiscountFreeDelivery implements Discount
{
    protected int $discount = 0;

    /**
     * Применение скидки
     * @param OrderBuilder $builder
     * @return bool
     */
    public function applyDiscount(OrderBuilder $builder): bool
    {
        // todo логика получения скидки
        $delivery = $builder->getDelivery();
        $this->discount = $delivery->getSum();

        return true;
    }

    /**
     * Возвращает сумму скидки
     * @return int
     */
    public function getDiscount(): int
    {
        return $this->discount;
    }
}
