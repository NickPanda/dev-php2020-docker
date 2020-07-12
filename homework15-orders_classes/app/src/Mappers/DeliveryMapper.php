<?php

declare(strict_types=1);

namespace App\Mappers;

use App\DTO\Delivery;

/**
 * Class DeliveryMapper
 * @package App\Mappers
 */
class DeliveryMapper extends Mapper
{
    /**
     * @var string
     */
    protected string $collectName = 'delivery';

    /**
     * @return Delivery
     */
    protected static function getDTO(): Delivery
    {
        return new Delivery();
    }

}
