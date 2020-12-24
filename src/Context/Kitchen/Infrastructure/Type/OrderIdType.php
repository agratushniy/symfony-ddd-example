<?php

declare(strict_types=1);

namespace App\Context\Kitchen\Infrastructure\Type;


use App\Context\Kitchen\Domain\OrderId;
use App\Context\Shared\Infrastructure\UuidIdType;

class OrderIdType extends UuidIdType
{
    protected const NAME = 'KitchenOrderId';

    protected function className(): string
    {
        return OrderId::class;
    }
}