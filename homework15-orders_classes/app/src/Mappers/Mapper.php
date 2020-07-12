<?php

declare(strict_types=1);

namespace App\Mappers;

use App\DTO\DTO;
use App\Interfaces\DB;

/**
 * Class Mapper
 * @package App\Mappers
 */
abstract class Mapper
{
    /**
     * @var DB|null $connect
     */
    protected ?DB $connect = null;

    public function __construct($db)
    {
        $this->connect = $db;
    }

    /**
     * @param $params
     * @return DTO|null
     */
    public function findOne($params): ?DTO
    {
        $db = $this->connect->findOne($this->collectName, $params);

        return $db ? $this->getDTO()->serialize($db) : null;
    }
}
