<?php

declare(strict_types=1);

namespace App\Mappers;

use Exception;
use App\DTO\DTO;
use App\DTO\Parcel;

/**
 * Class ParcelMapper
 * @package App\Mappers
 */
class ParcelMapper extends Mapper
{
    /**
     * @var string
     */
    protected string $collectName = 'parcels';

    /**
     * @return Parcel
     */
    protected static function getDTO(): Parcel
    {
        return new Parcel();
    }

    /**
     * @param Parcel|array $data
     * @return DTO
     * @throws \Exception
     */
    public function insert($data): DTO
    {
        $model = is_array($data) ? new Parcel($data) : $data;

        if (!$model->getWeight() || !$model->getSize()) {
            throw new \Exception('Свойства посылки не заданы!');
        }

        $id = $this->connect->insert(
            $this->collectName,
            [
                'code' => $model->getCode(),
                'size' => $model->getSize(),
                'weight' => $model->getWeight(),
            ]
        );

        $model->setId($id);

        return $model;
    }

    /**
     * @param Parcel $model
     * @return Parcel
     * @throws Exception
     */
    public function update(Parcel $model): DTO
    {
        if (!$model->getWeight() || !$model->getSize()) {
            throw new Exception('Свойства посылки не заданы!');
        }

        $this->connect->update(
            $this->collectName,
            ['id' => $model->getId()],
            [
                'code' => $model->getCode(),
                'size' => $model->getSize(),
                'weight' => $model->getWeight(),
            ]
        );

        return $model;
    }
}
