<?php

declare(strict_types=1);

namespace App\Context\Kitchen\Application\EventHandler;

use App\Context\Kitchen\Domain\IOrderBaseToKitchenTranslator;
use App\Context\Kitchen\Domain\IOrderRepository;
use App\Context\OrderManagement\Domain\Event\OrderHasBeenSentToTheKitchen;
use App\Context\Shared\Application\IEventHandler;
use App\Context\Shared\Domain\Error\DatabaseError;

/**
 * Создать заказ на кухне
 */
class CreateOrderOnKitchen implements IEventHandler
{
    /**
     * @var IOrderRepository
     */
    private IOrderRepository $orderRepository;
    /**
     * @var IOrderBaseToKitchenTranslator
     */
    private IOrderBaseToKitchenTranslator $orderTranslator;

    public function __construct(IOrderRepository $orderRepository, IOrderBaseToKitchenTranslator $orderTranslator)
    {
        $this->orderRepository = $orderRepository;
        $this->orderTranslator = $orderTranslator;
    }

    /**
     * @param OrderHasBeenSentToTheKitchen $event
     * @throws DatabaseError
     */
    public function __invoke(OrderHasBeenSentToTheKitchen $event)
    {
        $order = $this->orderTranslator->translate($event->orderId());
        $this->orderRepository->add($order);
    }
}