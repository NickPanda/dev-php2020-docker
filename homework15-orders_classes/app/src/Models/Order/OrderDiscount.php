<?php

declare(strict_types=1);

namespace App\Models\Order;

use App\Application;
use App\Interfaces\Discount;
use App\Mappers\DiscountMapper;

/**
 * Class OrderDiscount
 * @package App\Models\Order
 */
class OrderDiscount
{
    /**
     * Возвращает скидку
     * @param $discount_id
     * @return Discount
     */
    public function getDiscount($discount_id): Discount
    {
        $discount = (new DiscountMapper(Application::$DB))->findOne(['id' => $discount_id]);
        $className = "App\Models\Discount\Discount" . $discount->getCode();
        $discount = new $className();

        return $discount;
    }
}
