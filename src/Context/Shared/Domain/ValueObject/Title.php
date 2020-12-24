<?php

declare(strict_types=1);

namespace App\Context\Shared\Domain\ValueObject;

class Title extends StringValue
{
    protected function __construct($value)
    {
        parent::__construct($value);

        if (empty($value)) {
            //exception если хотим, что бы наименование было НЕ пустым
        }
    }
}