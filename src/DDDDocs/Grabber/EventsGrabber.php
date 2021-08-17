<?php

declare(strict_types=1);

namespace App\DDDDocs\Grabber;

use App\Context\Shared\Domain\Event;
use App\DDDDocs\Model\Context;
use Laminas\Code\Reflection\ClassReflection;
use Laminas\Code\Reflection\FileReflection;

class EventsGrabber implements IGrabber
{

    public function grab(ClassReflection $classReflection, Context $context): void
    {
        if (!$entity = $context->findEntityByFQCN($classReflection->getName())) {
            return;
        }

        /**
         * @var ClassReflection[] $importedEvents
         */
        $importedEvents = $this->getImportedEventClasses($classReflection);

        foreach ($classReflection->getMethods() as $methodReflection) {

            $methodName = $methodReflection->getName();

            if (!$entityMutator = $entity->findMutator($methodName)) {
                continue;
            }

            $methodContent = $methodReflection->getContents();

            foreach ($importedEvents as $importedEvent) {
                if (strpos($methodContent, $importedEvent->getShortName())) {

                    $event = new \App\DDDDocs\Model\Event();
                    $event->code = $importedEvent->getShortName();
                    $event->fqcn = $importedEvent->getName();
                    $event->title = $importedEvent->getDocBlock() ? $importedEvent->getDocBlock()->getShortDescription() : '';
                    $entityMutator->addEvent($event);
                }
            }
        }

    }

    private function getImportedEventClasses(ClassReflection $classReflection): array
    {
        $fileReflection = new FileReflection($classReflection->getFileName());
        $uses = $fileReflection->getUses();
        $events = [];

        foreach ($uses as $useClassName) {
            if (!class_exists($useClassName['use'])) {
                continue;
            }

            $eventClassReflection = new ClassReflection($useClassName['use']);

            if (!$eventClassReflection->isSubclassOf(Event::class)) {
                continue;
            }

            $events[] = $eventClassReflection;
        }

        return $events;
    }
}