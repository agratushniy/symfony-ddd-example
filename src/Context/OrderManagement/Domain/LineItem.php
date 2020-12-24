<?php

declare(strict_types=1);

namespace App\Context\OrderManagement\Domain;

use App\Context\Shared\Domain\DefaultEntity;
use App\Context\Shared\Domain\ValueObject\Money;
use App\Context\Shared\Domain\ValueObject\Title;

/**
 * Элемент заказа
 */
class LineItem extends DefaultEntity
{
    /**
     * @var Title
     */
    private Title $title;
    /**
     * @var Money
     */
    private Money $price;
    /**
     * @var Quantity
     */
    private Quantity $quantity;

    public function __construct(LineItemId $id, Title $title, Money $price, Quantity $quantity)
    {
        $this->id = $id;
        $this->title = $title;
        $this->price = $price;
        $this->quantity = $quantity;
    }

    /**
     * @return Title
     */
    public function title(): Title
    {
        return $this->title;
    }

    /**
     * @return Money
     */
    public function price(): Money
    {
        return $this->price;
    }

    /**
     * @return Quantity
     */
    public function quantity(): Quantity
    {
        return $this->quantity;
    }
}