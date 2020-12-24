<?php

declare(strict_types=1);

namespace App\Context\OrderManagement\Infrastructure\Type;

use App\Context\OrderManagement\Domain\OrderId;
use App\Context\Shared\Infrastructure\UuidIdType;

class OrderIdType extends UuidIdType
{
    protected const NAME = 'OrderId';

    protected function className(): string
    {
        return OrderId::class;
    }
}