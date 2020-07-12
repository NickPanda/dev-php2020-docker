<?php

declare(strict_types=1);

namespace App\Mappers;

use App\DTO\Product;

/**
 * Class ProductMapper
 * @package App\Mappers
 */
class ProductMapper extends Mapper
{
    /**
     * @var string
     */
    protected string $collectName = 'products';

    /**
     * @return Product
     */
    protected static function getDTO(): Product
    {
        return new Product();
    }
}
