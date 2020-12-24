<?php

declare(strict_types=1);

namespace App\Context\Kitchen\Infrastructure\Type;

use App\Context\Kitchen\Domain\DishId;
use App\Context\Shared\Infrastructure\UuidIdType;

class DishIdType extends UuidIdType
{
    protected const NAME = 'DishId';

    protected function className(): string
    {
        return DishId::class;
    }
}