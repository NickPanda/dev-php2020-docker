<?php

declare(strict_types=1);

namespace App\Interfaces;

use App\Models\Order\OrderBuilder;

/**
 * Interface Discount
 * @package App\Interfaces
 */
interface Discount
{
    /**
     * Применение скидки
     * @param OrderBuilder $builder
     * @return bool
     */
    public function applyDiscount(OrderBuilder $builder): bool;

    /**
     * Возвращает сумму скидки
     * @return int
     */
    public function getDiscount(): int;
}
