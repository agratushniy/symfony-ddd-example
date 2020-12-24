<?php

declare(strict_types=1);

namespace App\Context\OrderManagement\Application\Query\Handler;

use App\Context\OrderManagement\Application\Query\Assembler\OrderAssembler;
use App\Context\OrderManagement\Application\Query\GetAllOrders;
use App\Context\OrderManagement\Domain\IOrderRepository;
use App\Context\Shared\Application\Bus\Query\IQueryHandler;

class GetAllOrdersHandler implements IQueryHandler
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

    public function __invoke(GetAllOrders $query)
    {
        $orders = [];

        foreach ($this->orderRepository->findAllItems() as $order) {
            $orders[] = $this->assembler->assemble($order);
        }

        return $orders;
    }
}