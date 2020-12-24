<?php

declare(strict_types=1);

namespace App\Context\OrderManagement\Domain;

use App\Context\OrderManagement\Domain\Event\OrderClosed;
use App\Context\OrderManagement\Domain\Event\OrderHasBeenSentToTheKitchen;
use App\Context\Shared\Domain\AggregateRoot;
use Doctrine\Common\Collections\Collection;

/**
 * @method OrderId id()
 */
class Order extends AggregateRoot
{
    private const STATUS_NEW = 'new';
    private const STATUS_ON_KITCHEN = 'onKitchen';
    private const STATUS_COOKED = 'cooked';
    private const STATUS_CLOSED = 'closed';

    private Collection $items;
    private string $status;

    public function __construct(OrderId $id, Collection $lineItems)
    {
        $this->id = $id;

        if ($lineItems->isEmpty()) {
            //exception
        }

        $this->items = $lineItems;
        $this->status = self::STATUS_NEW;
    }

    /**
     * @return string
     */
    public function status(): string
    {
        return $this->status;
    }

    /**
     * Отправить на кухню
     */
    public function sendToKitchen(): void
    {
        if ($this->status !== self::STATUS_NEW) {
            //exception
        }

        $this->status = self::STATUS_ON_KITCHEN;
        $this->record(new OrderHasBeenSentToTheKitchen($this->id()->value()));
    }

    /**
     * Приготовить
     */
    public function cook(): void
    {
        if ($this->status !== self::STATUS_ON_KITCHEN) {
            //exception
        }

        $this->status = self::STATUS_COOKED;
    }

    /**
     * Закрыть заказ
     */
    public function close(): void
    {
        if ($this->status !== self::STATUS_COOKED) {
            //exception
        }

        $this->status = self::STATUS_CLOSED;
        $this->record(new OrderClosed($this->id()));
    }

    /**
     * @return Collection|LineItem[]
     */
    public function items(): Collection
    {
        return $this->items;
    }
}