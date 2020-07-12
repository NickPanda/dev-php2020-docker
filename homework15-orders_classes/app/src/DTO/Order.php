<?php

declare(strict_types=1);

namespace App\DTO;

/**
 * Class Order
 * @package App\DTO
 */
class Order extends DTO
{
    /**
     * @var int
     */
    private int $id;

    /**
     * @var int
     */
    private int $client_id;

    /**
     * @var float|int
     */
    private $sum;

    /**
     * @var int
     */
    private int $status = 1;

    /**
     * @var int
     */
    private int $delivery_id;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getClientId(): int
    {
        return $this->client_id;
    }

    /**
     * @param int $client_id
     */
    public function setClientId(int $client_id): void
    {
        $this->client_id = $client_id;
    }

    /**
     * @return float|int
     */
    public function getSum()
    {
        return $this->sum;
    }

    /**
     * @param float $sum
     */
    public function setSum($sum): void
    {
        $this->sum = $sum;
    }

    /**
     * @return int
     */
    public function getStatus(): int
    {
        return $this->status;
    }

    /**
     * @param int $status
     */
    public function setStatus(int $status): void
    {
        $this->status = $status;
    }

    /**
     * @return int
     */
    public function getDeliveryId(): int
    {
        return $this->delivery_id;
    }

    /**
     * @param int $delivery_id
     */
    public function setDeliveryId(int $delivery_id): void
    {
        $this->delivery_id = $delivery_id;
    }
}
