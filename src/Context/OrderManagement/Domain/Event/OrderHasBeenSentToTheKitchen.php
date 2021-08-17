<?php

declare(strict_types=1);

namespace App\Context\OrderManagement\Domain\Event;

use App\Context\Shared\Domain\Event;

/**
 * Заказ был отправлен на кухню
 */
class OrderHasBeenSentToTheKitchen extends Event
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