<?php

declare(strict_types=1);

namespace App\DTO;

/**
 * Class Parcel
 * @package App\DTO
 */
class Parcel extends DTO
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private string $code = '';

    /**
     * @var int
     */
    private int $weight = 0;

    /**
     * @var int
     */
    private int $size = 0;

    /**
     * @return int
     */
    public function getId(): ?int
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
     * @return string
     */
    public function getCode(): string
    {
        return $this->code;
    }

    /**
     * @param string $code
     */
    public function setCode(string $code)
    {
        $this->code = $code;
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
    public function setWeight(int $weight)
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
    public function setSize(int $size)
    {
        $this->size = $size;
    }

}
