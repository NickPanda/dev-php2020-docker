<?php

declare(strict_types=1);

namespace App\DTO;

/**
 * Class ProductOrder
 * @package App\DTO
 */
class ProductOrder extends DTO
{
    /**
     * @var int
     */
    private int $product_id;

    /**
     * @var int
     */
    private int $order_id;

    /**
     * @var int
     */
    private int $count;

    /**
     * @var int
     */
    private ?int $parcel_id = null;

    /**
     * @return int
     */
    public function getProductId(): int
    {
        return $this->product_id;
    }

    /**
     * @param int $product_id
     */
    public function setProductId(int $product_id): void
    {
        $this->product_id = $product_id;
    }

    /**
     * @return int
     */
    public function getOrderId(): int
    {
        return $this->order_id;
    }

    /**
     * @param int $order_id
     */
    public function setOrderId(int $order_id): void
    {
        $this->order_id = $order_id;
    }


    /**
     * @return int
     */
    public function getCount(): int
    {
        return $this->count;
    }

    /**
     * @param int $count
     */
    public function setCount(int $count): void
    {
        $this->count = $count;
    }

    /**
     * @return int
     */
    public function getParcelId(): ?int
    {
        return $this->parcel_id;
    }

    /**
     * @param int $parcel_id
     */
    public function setParcelId(int $parcel_id): void
    {
        $this->parcel_id = $parcel_id;
    }
}
