<?php

declare(strict_types=1);

namespace App\Context\Shared\Domain\Contract;

/**
 * Идентификатор
 */
interface IId extends IValueObject
{
    /**
     * @return integer|string
     */
    public function value();
}
