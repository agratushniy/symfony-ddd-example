<?php

declare(strict_types=1);

namespace App\Context\Shared\Domain\Contract;

/**
 * Доменный объект
 */
interface IDomainObject
{
    /**
     * @param IDomainObject $object
     *
     * @return bool
     */
    public function sameTypeAs(IDomainObject $object): bool;

    /**
     * @param string $className
     *
     * @return bool
     */
    public function typeOf(string $className): bool;

    public function typeIs(string $className): bool;

    /**
     * Сравнить два значения
     *
     * @param IDomainObject $object
     * @return bool
     */
    public function equals(IDomainObject $object): bool;
}
