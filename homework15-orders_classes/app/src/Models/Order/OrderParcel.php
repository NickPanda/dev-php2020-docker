<?php

declare(strict_types=1);

namespace App\Models\Order;

use App\Application;
use App\DTO\Parcel;
use App\Mappers\ParcelMapper;
use App\Mappers\ProductMapper;
use App\Mappers\ProductOrderMapper;

/**
 * Class OrderParcel
 * @package App\Models\Order
 */
class OrderParcel
{
    /**
     * @var Parcel
     */
    public $parcel;

    // Максимальный вес посылки
    public const MAX_SIZE_PARCEL = 50;

    public function __construct(Order $orderModel)
    {
        foreach ($orderModel->productOrder as $productOrder) {
            $this->sort();

            $product = (new ProductMapper(Application::$DB))->findOne(['id' => $productOrder->getProductId()]);

            $this->parcel->setSize($productOrder->getCount() * $product->getSize() + $this->parcel->getSize());
            $this->parcel->setWeight($productOrder->getCount() * $product->getWeight() + $this->parcel->getWeight());

            $this->save();

            $productOrder->setParcelId($this->parcel->getId());
            (new ProductOrderMapper(Application::$DB))->update($productOrder);
        }

        return $this;
    }

    /**
     * Сортировка товаров по посылкам
     */
    public function sort(): void
    {
        if (!$this->parcel || $this->parcel->getSize() >= self::MAX_SIZE_PARCEL) {
            $this->parcel = new Parcel();
        }
    }

    /**
     * Сохранение посылки в БД
     * @throws \Exception
     */
    public function save(): void
    {
        if (!$this->parcel->getId()) {
            (new ParcelMapper(Application::$DB))->insert($this->parcel);
        } else {
            (new ParcelMapper(Application::$DB))->update($this->parcel);
        }
    }
}
