<?php

declare(strict_types=1);

namespace App\Models\Order;

use App\Application;
use App\DTO\Order;
use App\DTO\Client;
use App\DTO\ProductOrder;
use App\Interfaces\Discount;
use App\Interfaces\Delivery;
use App\Mappers\ProductMapper;

/**
 * Class OrderBuilder
 * @package App\Models\Order
 */
class OrderBuilder
{
    /**
     * @var Order
     */
    protected ?Order $order = null;

    /**
     * @var Discount
     */
    protected Discount $discount;

    /**
     * @var Delivery
     */
    protected ?Delivery $delivery;

    /**
     * @var array
     */
    protected array $products;

    /**
     * @var array
     */
    protected array $productOrder;


    /**
     * OrderBuilder constructor.
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->order = new Order();
        $this->order->setClientId($client->getId());
    }

    /**
     * Добавление товара
     * @param $product_id
     * @param $count
     * @return self
     */
    public function addProduct($product_id, $count): self
    {
        $product = (new ProductMapper(Application::$DB))->findOne(['id' => $product_id]);
        $this->productOrder[] = new ProductOrder(
            [
                'product_id' => $product->getId(),
                'count' => $count,
            ]
        );

        // todo логика проверки остатков и списания

        $this->products[] = $product;
        $this->afterAddProduct($product, $count);

        return $this;
    }

    /**
     * Выберем доставку
     * @param $delivery_id
     * @return self
     */
    public function setDelivery($delivery_id): self
    {
        $this->delivery = (new OrderDelivery())->getDelivery($delivery_id);
        $this->delivery->calculate($this);
        $this->order->setDeliveryId($delivery_id);

        return $this;
    }

    /**
     * Применяем скидку
     * @param $discount_id
     * @return self
     */
    public function setDiscount($discount_id): self
    {
        $this->discount = (new OrderDiscount())->getDiscount($discount_id);
        $this->discount->applyDiscount($this);

        return $this;
    }

    /**
     * Событие после добавление нового товара
     * @param $product
     * @param $count
     * @return bool
     */
    protected function afterAddProduct($product, $count): bool
    {
        $sum = $this->order->getSum() + $count * $product->getPrice();
        $this->order->setSum($sum);

        return true;
    }

    /**
     * Расчет суммы заказа с учетом доставки и скидки
     * @return self
     */
    public function calculate(): self
    {
        // Считаем итоговую сумму и кол-во товара
        (new OrderCalculate())->calculate($this);

        return $this;
    }

    /**
     * @return Order
     */
    public function getOrder(): Order
    {
        return $this->order;
    }

    /**
     * @return Delivery
     */
    public function getDelivery(): Delivery
    {
        return $this->delivery;
    }

    /**
     * @return Discount
     */
    public function getDiscount(): Discount
    {
        return $this->discount;
    }

    /**
     * @return array
     */
    public function getProductOrder(): array
    {
        return $this->productOrder;
    }
}
