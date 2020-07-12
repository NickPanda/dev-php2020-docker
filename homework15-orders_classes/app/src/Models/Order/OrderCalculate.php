<?php

declare(strict_types=1);

namespace App\Models\Order;

/**
 * Class OrderCalculate
 * @package App\Models\Order
 */
class OrderCalculate
{
    /**
     * Расчет суммы заказа с учетом доставки и скидки
     * @param OrderBuilder $builder
     */
    public function calculate(OrderBuilder $builder): void
    {
        $delivery = $builder->getDelivery();
        $order = $builder->getOrder();
        $discount = $builder->getDiscount();

        $sum = $order->getSum() + $delivery->getSum() - $discount->getDiscount();
        $order->setSum($sum);
    }
}
