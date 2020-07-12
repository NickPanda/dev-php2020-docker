<?php

declare(strict_types=1);

namespace App\Mappers;

use App\DTO\DTO;
use App\DTO\ProductOrder;

/**
 * Class ProductOrderMapper
 * @package App\Mappers
 */
class ProductOrderMapper extends Mapper
{
    /**
     * @var string
     */
    protected string $collectName = 'product_order';

    /**
     * @return ProductOrder
     */
    protected static function getDTO(): ProductOrder
    {
        return new ProductOrder();
    }

    /**
     * @param array|DTO $data
     * @return DTO
     * @throws \Exception
     */
    public function insert($data): DTO
    {
        $model = is_array($data) ? new ProductOrder($data) : $data;

        if (!$model->getOrderId() || !$model->getProductId()) {
            throw new \Exception('Свойства товара в заказе не переданы!');
        }

        $this->connect->insert(
            $this->collectName,
            [
                'product_id' => $model->getProductId(),
                'order_id' => $model->getOrderId(),
                'count' => $model->getCount(),
                'parcel_id' => $model->getParcelId(),
            ]
        );

        return $model;
    }

    /**
     * @param ProductOrder $model
     * @return ProductOrder
     * @throws \Exception
     */
    public function update(ProductOrder $model): DTO
    {
        if (!$model->getOrderId() || !$model->getProductId()) {
            throw new \Exception('Свойства товара в заказе не переданы');
        }

        $this->connect->update(
            $this->collectName,
            [
                'product_id' => $model->getProductId(),
                'order_id' => $model->getOrderId(),
            ],
            [
                'product_id' => $model->getProductId(),
                'order_id' => $model->getOrderId(),
                'count' => $model->getCount(),
                'parcel_id' => $model->getParcelId(),
            ]
        );

        return $model;
    }
}
