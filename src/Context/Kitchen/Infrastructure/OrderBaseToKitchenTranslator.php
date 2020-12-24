<?php

declare(strict_types=1);

namespace App\Context\Kitchen\Infrastructure;

use App\Context\Kitchen\Domain\DishId;
use App\Context\Kitchen\Domain\IOrderBaseToKitchenTranslator;
use App\Context\Kitchen\Domain\Order;
use App\Context\Kitchen\Domain\OrderId;
use App\Context\Kitchen\Domain\Dish;
use App\Context\OrderManagement\Domain\IOrderRepository;
use Doctrine\Common\Collections\ArrayCollection;

class OrderBaseToKitchenTranslator implements IOrderBaseToKitchenTranslator
{
    /**
     * @var IOrderRepository
     */
    private IOrderRepository $orderRepository;

    public function __construct(IOrderRepository $orderRepository)
    {
        $this->orderRepository = $orderRepository;
    }

    public function translate(string $baseOrderId): Order
    {
        $baseOrder = $this->orderRepository->findOneById(\App\Context\OrderManagement\Domain\OrderId::create($baseOrderId));

        if (!$baseOrder) {
            //exception
        }

        $orderId = OrderId::create($baseOrderId);
        $dishes = new ArrayCollection();

        foreach ($baseOrder->items() as $orderItem) {
            for ($i = 1; $i <= $orderItem->quantity()->value(); $i++) {
                $dishes->add(new Dish(DishId::generateNext(), $orderItem->title()));
            }
        }

        return new Order($orderId, $dishes);
    }
}