<?php

declare(strict_types=1);

namespace App\Context\OrderManagement\Domain\Event;

use App\Context\OrderManagement\Domain\OrderId;
use App\Context\Shared\Domain\Event;

class OrderClosed extends Event
{
    public function __construct(OrderId $orderId)
    {
    }
}