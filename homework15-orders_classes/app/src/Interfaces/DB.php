<?php

declare(strict_types=1);

namespace App\Interfaces;

/**
 * Interface DB
 * @package App\Interfaces
 */
interface DB
{
    /**
     * @return DB
     */
    public function connect(): DB;

    /**
     * @param string $collection
     * @param array $data
     * @return int
     */
    public function insert(string $collection, array $data): int;

    /**
     * @param string $collection
     * @param array $filter
     * @param array $data
     * @return bool
     */
    public function update(string $collection, array $filter, array $data): bool;

    /**
     * @param string $collection
     * @param array $params
     * @return object|null
     */
    public function findAll(string $collection, array $params);

    /**
     * @param $collection
     * @param $params
     * @return object|null
     */
    public function findOne(string $collection, array $params);
}
