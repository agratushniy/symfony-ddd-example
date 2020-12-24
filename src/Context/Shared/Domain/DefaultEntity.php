<?php


declare(strict_types=1);

namespace App\Context\Shared\Domain;


use App\Context\Shared\Domain\Contract\IDomainObject;
use App\Context\Shared\Domain\Contract\IEntity;
use App\Context\Shared\Domain\Contract\IId;

abstract class DefaultEntity extends DefaultObject implements IEntity
{
    protected $events = [];

    /**
     * @var IId
     */
    protected $id;

    /**
     * @param IDomainObject $object
     * @return bool
     */
    public function equals(IDomainObject $object): bool
    {
        /**
         * @var static $object
         */
        return $this->sameTypeAs($object) && $this->id()->equals($object->id());
    }

    /**
     * Извлечь все события
     * @return Event[]
     */
    public function popEvents(): array
    {
        $events = $this->events;
        $this->events = [];

        return $events;
    }

    /**
     * @return IId
     */
    public function id(): IId
    {
        return $this->id;
    }

    /**
     * Записать событие
     * @param Event $event
     */
    protected function record(Event $event): void
    {
        $this->events[] = $event;
    }
}
