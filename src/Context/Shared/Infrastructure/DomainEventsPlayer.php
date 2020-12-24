<?php

namespace App\Context\Shared\Infrastructure;

use App\Context\Shared\Domain\DefaultEntity;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\PostFlushEventArgs;
use Doctrine\ORM\Events;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;


final class DomainEventsPlayer implements EventSubscriber
{
    private array $entities = [];

    private EventDispatcherInterface $eventDispatcher;

    /**
     * @inheritDoc
     */
    public function getSubscribedEvents()
    {
        return [
            Events::postPersist,
            Events::postUpdate,
            Events::postRemove,
            Events::postFlush
        ];
    }

    public function __construct(EventDispatcherInterface $eventDispatcher)
    {
        $this->eventDispatcher = $eventDispatcher;
    }

    public function postPersist($event): void
    {
        $this->keepEntities($event);
    }

    public function postUpdate($event): void
    {
        $this->keepEntities($event);
    }

    public function postRemove($event): void
    {
        $this->keepEntities($event);
    }

    public function postFlush(PostFlushEventArgs $doctrineEvent): void
    {
        foreach ($this->entities as $entity) {
            /**
             * @var DefaultEntity $entity
             */
            foreach ($entity->popEvents() as $event) {
                $this->eventDispatcher->dispatch($event);
            }
        }

        $this->entities = [];
    }

    private function keepEntities(LifecycleEventArgs $event): void
    {
        $entity = $event->getObject();

        if (!($entity instanceof DefaultEntity)) {
            return;
        }

        $this->entities[] = $entity;
    }
}