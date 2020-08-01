<?php

declare(strict_types=1);

namespace App\DTO;

/**
 * Class Product
 * @package App\DTO
 */
class Product extends DTO
{
    /**
     * @var int
     */
    private int $id;

    /**
     * @var int
     */
    private int $group_id;

    /**
     * @var string
     */
    private string $name = '';

    /**
     * @var string
     */
    private string $price;

    /**
     * @var int
     */
    private int $weight;

    /**
     * @var int
     */
    private int $size;

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
    public function getGroupId(): int
    {
        return $this->group_id;
    }

    /**
     * @param int $group_id
     */
    public function setGroupId(int $group_id): void
    {
        $this->group_id = $group_id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string numeric
     */
    public function getPrice(): string
    {
        return $this->price;
    }

    /**
     * @param string $price numeric
     */
    public function setPrice(string $price): void
    {
        $this->price = $price;
    }

    /**
     * @return int
     */
    public function getWeight(): int
    {
        return $this->weight;
    }

    /**
     * @param int $weight
     */
    public function setWeight(int $weight): void
    {
        $this->weight = $weight;
    }

    /**
     * @return int
     */
    public function getSize(): int
    {
        return $this->size;
    }

    /**
     * @param int $size
     */
    public function setSize(int $size): void
    {
        $this->size = $size;
    }
}
