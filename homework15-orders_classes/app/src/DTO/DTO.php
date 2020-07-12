<?php

declare(strict_types=1);

namespace App\DTO;

/**
 * Class DTO
 * @package App\DTO
 */
abstract class DTO
{
    /**
     * DTO constructor.
     * @param array $data
     */
    public function __construct(array $data = [])
    {
        $this->serialize($data);
    }

    /**
     * @param array $data
     * @return DTO
     */
    public function serialize(array $data): DTO
    {
        if (empty($data)) {
            return $this;
        }

        foreach ($data as $key => $param) {
            $method = "set" . preg_replace("/_/", "", $key);
            if (method_exists($this, $method) && $param) {
                $this->$method($param);
            }
        }

        return $this;
    }

    /**
     * @param array $datas
     * @return array
     */
    public function serializeAll(array $datas): array
    {
        if (empty($datas)) {
            return [];
        }

        $models = [];
        foreach ($datas as $data) {
            $model = (new static)->serialize($data);
            $models[] = $model;
        }

        return $models;
    }
}
