<?php

declare(strict_types=1);

namespace App\Context\Kitchen\Application\Query\Assembler;

use App\Context\Kitchen\Application\Query\Dto\DishDto;
use App\Context\Kitchen\Application\Query\Dto\OrderOnKitchenDto;
use App\Context\Kitchen\Domain\Dish;
use App\Context\Kitchen\Domain\Order;

class OrderAssembler
{
    public function assemble(Order $order): OrderOnKitchenDto
    {
        $dto = new OrderOnKitchenDto();

        $dto->id = $order->id()->value();
        $dto->dishes = [];

        foreach ($order->dishes() as $dish) {
            $dto->dishes[] = $this->assembleDish($dish);
        }

        return $dto;
    }

    protected function assembleDish(Dish $dish): DishDto
    {
        $dto = new DishDto();
        $dto->id = $dish->id()->value();
        $dto->title = $dish->title()->value();
        $dto->cooked = $dish->cooked();

        return $dto;
    }
}