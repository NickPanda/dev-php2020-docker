<?php

declare(strict_types=1);

namespace App\Mappers;

use App\DTO\Discount;

/**
 * Class DiscountMapper
 * @package App\Mappers
 */
class DiscountMapper extends Mapper
{
    /**
     * @var string
     */
    protected string $collectName = 'discounts';

    /**
     * @return Discount
     */
    protected static function getDTO(): Discount
    {
        return new Discount();
    }
}
