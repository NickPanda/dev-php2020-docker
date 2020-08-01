<?php

declare(strict_types=1);

namespace App\Interfaces;

use App\Models\Order\OrderBuilder;

/**
 * Interface Delivery
 * @package App\Interfaces
 */
interface Delivery
{
    /**
     * Расчет цены доставки.
     * @param OrderBuilder $builder
     * @return bool
     */
    public function calculate(OrderBuilder $builder): bool;

    /**
     * Возвращает сумму доставки.
     * @return int
     */
    public function getSum(): int;
}
