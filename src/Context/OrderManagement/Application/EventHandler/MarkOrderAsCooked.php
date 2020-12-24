<?php

declare(strict_types=1);

namespace App\Context\OrderManagement\Application\EventHandler;

use App\Context\Kitchen\Domain\Event\OrderCookedOnKitchen;
use App\Context\OrderManagement\Domain\IOrderRepository;
use App\Context\OrderManagement\Domain\OrderId;
use App\Context\Shared\Application\IEventHandler;
use App\Context\Shared\Domain\Error\DatabaseError;

/**
 * Перевести заказ в статус приготовлен
 */
class MarkOrderAsCooked implements IEventHandler
{
    /**
     * @var IOrderRepository
     */
    private IOrderRepository $orderRepository;

    public function __construct(IOrderRepository $orderRepository)
    {
        $this->orderRepository = $orderRepository;
    }

    /**
     * @param OrderCookedOnKitchen $event
     * @throws DatabaseError
     */
    public function __invoke(OrderCookedOnKitchen $event)
    {
        if (!$order = $this->orderRepository->findOneById(OrderId::create($event->orderId()))) {
            //exception
        }

        $order->cook();
        $this->orderRepository->persistChanges($order);
    }
}