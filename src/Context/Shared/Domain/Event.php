<?php

declare(strict_types=1);

namespace App\Context\Shared\Domain;


use App\Context\Shared\Domain\Contract\IDomainObject;

/**
 * Доменное событие
 * Class DefaultEvent
 * @package Hans\Shared\Domain\Model\Event
 */
abstract class Event extends DefaultObject
{
    public function equals(IDomainObject $object): bool
    {
        // TODO: Implement equals() method.
    }
}