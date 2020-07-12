<?php

declare(strict_types=1);

namespace App\Mappers;

use App\DTO\Client;

/**
 * Class ClientMapper
 * @package App\Mappers
 */
class ClientMapper extends Mapper
{
    /**
     * @var string
     */
    protected string $collectName = 'clients';

    protected static function getDTO()
    {
        return new Client();
    }
}
