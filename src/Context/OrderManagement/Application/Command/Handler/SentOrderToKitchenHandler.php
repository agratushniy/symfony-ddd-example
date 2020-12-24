<?php

declare(strict_types=1);

namespace App\Context\OrderManagement\Application\Command\Handler;

use App\Context\OrderManagement\Application\Command\SendOrderToKitchen;
use App\Context\OrderManagement\Domain\IOrderRepository;
use App\Context\Shared\Application\Bus\Command\ICommandHandler;
use App\Context\Shared\Domain\Error\DatabaseError;

class SentOrderToKitchenHandler implements ICommandHandler
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
     * @param SendOrderToKitchen $command
     * @throws DatabaseError
     */
    public function __invoke(SendOrderToKitchen $command)
    {
        if ($order = $this->orderRepository->findOneById($command->orderId())) {
            //exception
        }

        $order->sendToKitchen();
        $this->orderRepository->persistChanges($order);
    }
}