<?php

declare(strict_types=1);

namespace App\Context\Shared\Domain\Contract;

/**
 * Сущность
 */
interface IEntity extends IDomainObject
{
    /**
     * @return IId
     */
    public function id(): IId;
}
