<?php

declare(strict_types=1);

namespace App\Context\Kitchen\Application\Command\Handler;

use App\Context\Kitchen\Application\Command\CompleteCookingDish;
use App\Context\Kitchen\Domain\IOrderRepository;
use App\Context\Shared\Application\Bus\Command\ICommandHandler;
use App\Context\Shared\Domain\Error\DatabaseError;

class CompleteCookingDishHandler implements ICommandHandler
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
     * @param CompleteCookingDish $command
     * @throws DatabaseError
     */
    public function __invoke(CompleteCookingDish $command)
    {
        if (!$order = $this->orderRepository->findOneById($command->orderId())) {
            //exception
        }

        $order->completeCookingDish($command->dishId());
        $this->orderRepository->persistChanges($order);
    }
}