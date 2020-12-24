<?php

declare(strict_types=1);

namespace App\Context\Shared\Domain\ValueObject;

use App\Context\Shared\Domain\SimpleValueObject;

/**
 * Положительное целочисленное значение
 */
class PositiveIntegerValue extends SimpleValueObject
{
    public function __construct($value)
    {
        $value = filter_var($value, FILTER_VALIDATE_INT) ?: 0; //TODO можно бросить exception
        parent::__construct($value);
    }

    /**
     * Больше?
     * @param PositiveIntegerValue $otherObject
     * @return bool
     */
    public function gt(PositiveIntegerValue $otherObject): bool
    {
        return $this->value() > $otherObject->value();
    }

    /**
     * Меньше?
     * @param PositiveIntegerValue $otherObject
     * @return bool
     */
    public function lv(PositiveIntegerValue $otherObject): bool
    {
        return $this->value() < $otherObject->value();
    }
}