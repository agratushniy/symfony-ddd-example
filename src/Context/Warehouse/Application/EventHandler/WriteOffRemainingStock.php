<?php

declare(strict_types=1);

namespace App\Context\Warehouse\Application\EventHandler;

use App\Context\OrderManagement\Domain\Event\OrderClosed;
use App\Context\Shared\Application\IEventHandler;

/**
 * Списать остатки на складе
 */
class WriteOffRemainingStock implements IEventHandler
{
    public function __invoke(OrderClosed $event)
    {
        // TODO: Implement __invoke() method.
    }
}