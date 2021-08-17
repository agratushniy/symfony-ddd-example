<?php

declare(strict_types=1);

namespace App\Context\OrderManagement\Application\Command;

use App\Context\OrderManagement\Domain\OrderId;
use App\Context\Shared\Application\Bus\Command\ICommand;

/**
 * Закрыть заказ
 */
class CloseOrder implements ICommand
{
    /**
     * Идентификатор заказа
     * @var OrderId
     */
    private OrderId $orderId;

    public function __construct(string $orderId)
    {
        $this->orderId = OrderId::create($orderId);
    }

    /**
     * @return OrderId
     */
    public function orderId(): OrderId
    {
        return $this->orderId;
    }
}