<?php

declare(strict_types=1);

namespace App\Context\Shared\Domain\ValueObject;

use App\Context\Shared\Domain\SimpleValueObject;

/**
 * Строковое значение
 */
class StringValue extends SimpleValueObject
{
    protected function __construct($value)
    {
        $value = filter_var($value, FILTER_SANITIZE_STRING) ?: ''; //TODO можно бросить exception

        parent::__construct($value);
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string)$this->value();
    }
}