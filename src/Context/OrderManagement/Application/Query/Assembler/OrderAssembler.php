<?php

declare(strict_types=1);

namespace App\Context\OrderManagement\Application\Query\Assembler;

use App\Context\OrderManagement\Application\Query\Dto\OrderDto;
use App\Context\OrderManagement\Application\Query\Dto\OrderItemDto;
use App\Context\OrderManagement\Domain\Order;
use App\Context\OrderManagement\Domain\LineItem;

class OrderAssembler
{
    public function assemble(Order $order): OrderDto
    {
        $dto = new OrderDto();
        $dto->id = $order->id()->value();
        $dto->status = $order->status();
        $dto->items = [];

        foreach ($order->items() as $item) {
            $dto->items[] = $this->assembleItem($item);
        }

        return $dto;
    }

    protected function assembleItem(LineItem $item): OrderItemDto
    {
        $dto = new OrderItemDto();
        $dto->id = $item->id()->value();
        $dto->title = $item->title()->value();
        $dto->price = $item->price()->roubles();
        $dto->quantity = $item->quantity()->value();

        return $dto;
    }
}