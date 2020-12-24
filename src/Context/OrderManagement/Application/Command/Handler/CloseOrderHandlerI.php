<?php

declare(strict_types=1);

namespace App\Context\OrderManagement\Application\Command\Handler;

use App\Context\OrderManagement\Application\Command\CloseOrder;
use App\Context\OrderManagement\Domain\IOrderRepository;
use App\Context\Shared\Application\Bus\Command\ICommandHandler;
use App\Context\Shared\Domain\Error\DatabaseError;

class CloseOrderHandlerI implements ICommandHandler
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
     * @param CloseOrder $command
     * @throws DatabaseError
     */
    public function __invoke(CloseOrder $command)
    {
        if (!$order = $this->orderRepository->findOneById($command->orderId())) {
            //exception
        }

        $order->close();
        $this->orderRepository->persistChanges($order);
    }
}