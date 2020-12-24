<?php

declare(strict_types=1);

namespace App\Context\Kitchen\Application\Query\Handler;

use App\Context\Kitchen\Application\Query\Assembler\OrderAssembler;
use App\Context\Kitchen\Application\Query\GetAllOrdersOnKitchen;
use App\Context\Kitchen\Domain\IOrderRepository;
use App\Context\Shared\Application\Bus\Query\IQueryHandler;

class GetAllOrdersOnKitchenHandler implements IQueryHandler
{
    /**
     * @var IOrderRepository
     */
    private IOrderRepository $orderRepository;
    /**
     * @var OrderAssembler
     */
    private OrderAssembler $assembler;

    public function __construct(IOrderRepository $orderRepository, OrderAssembler $assembler)
    {
        $this->orderRepository = $orderRepository;
        $this->assembler = $assembler;
    }

    public function __invoke(GetAllOrdersOnKitchen $query)
    {
        $orders = [];

        foreach ($this->orderRepository->findAllItems() as $order) {
            $orders[] = $this->assembler->assemble($order);
        }

        return $orders;
    }
}