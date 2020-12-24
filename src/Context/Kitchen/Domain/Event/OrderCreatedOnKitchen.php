<?php

declare(strict_types=1);

namespace App\Context\Kitchen\Domain\Event;

use App\Context\Shared\Domain\Event;

/**
 * На кухне создался заказ
 */
class OrderCreatedOnKitchen extends Event
{
    private string $orderId;

    public function __construct(string $orderId)
    {
        $this->orderId = $orderId;
    }

    /**
     * @return string
     */
    public function orderId(): string
    {
        return $this->orderId;
    }
}