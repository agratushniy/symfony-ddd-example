<?php

declare(strict_types=1);

namespace App\Context\Shared\Domain;

use App\Context\Shared\Domain\Contract\IDomainObject;

abstract class DefaultObject implements IDomainObject
{
    /**
     * @param IDomainObject $object
     *
     * @return bool
     */
    final public function sameTypeAs(IDomainObject $object): bool
    {
        return static::className() === $object::className();
    }

    /**
     * @param string $className
     * @return bool
     */
    final public function typeIs(string $className): bool
    {
        return static::class === $className;
    }

    final public function typeOf(string $className): bool
    {
        return $this instanceof $className;
    }

    /**
     * @return string
     */
    final protected static function className(): string
    {
        return static::class;
    }
}
