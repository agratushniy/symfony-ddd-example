<?php

declare(strict_types=1);

namespace App\Context\OrderManagement\Infrastructure\Type;


use App\Context\OrderManagement\Domain\LineItemId;
use App\Context\Shared\Infrastructure\UuidIdType;

class LineItemIdType extends UuidIdType
{
    protected const NAME = 'LineItemId';

    protected function className(): string
    {
        return LineItemId::class;
    }
}