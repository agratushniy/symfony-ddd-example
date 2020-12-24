<?php

declare(strict_types=1);

namespace App\Context\Kitchen\Application\Command;

use App\Context\Kitchen\Domain\DishId;
use App\Context\Kitchen\Domain\OrderId;
use App\Context\Shared\Application\Bus\Command\ICommand;

/**
 * Приготовить блюдо
 */
class CompleteCookingDish implements ICommand
{
    private DishId $dishId;
    private OrderId $orderId;

    public function __construct(string $orderId, string $dishId)
    {
        $this->dishId = DishId::create($dishId);
        $this->orderId = OrderId::create($orderId);
    }

    /**
     * @return OrderId
     */
    public function orderId(): OrderId
    {
        return $this->orderId;
    }

    /**
     * @return DishId
     */
    public function dishId(): DishId
    {
        return $this->dishId;
    }
}