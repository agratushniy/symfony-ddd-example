<?php

declare(strict_types=1);

namespace App\DDDDocs\Grabber;

use App\Context\Shared\Application\IEventHandler;
use App\DDDDocs\ClassLoader;
use App\DDDDocs\Model\Context;
use App\DDDDocs\Model\EventSubscriber;
use Laminas\Code\Reflection\ClassReflection;

class EventSubscriberGrabber implements IGrabber
{
    private ClassLoader $classLoader;

    public function __construct(ClassLoader $classLoader)
    {
        $this->classLoader = $classLoader;
    }

    public function grab(ClassReflection $classReflection, Context $context): void
    {
        if (!$entity = $context->findEntityByFQCN($classReflection->getName())) {
            return;
        }

        $sourceClasses = $this->classLoader->load();

        foreach ($entity->events() as $event) {
            foreach ($sourceClasses as $class) {
                $subscriberReflection = new ClassReflection($class);

                if (!$subscriberReflection->implementsInterface(IEventHandler::class)) {
                    continue;
                }

                if (!$subscriberReflection->hasMethod('__invoke')) {
                    continue;
                }

                $invokeMethod = $subscriberReflection->getMethod('__invoke');
                $invokeParams = $invokeMethod->getParameters();

                if (!isset($invokeParams[0])) {
                    continue;
                }

                $eventParam = $invokeParams[0];

                if (!$eventParam->getClass()) {
                    continue;
                }

                if ($eventParam->getClass()->getName() !== $event->fqcn) {
                    continue;
                }

                preg_match('/^App\\\Context\\\(\w+).*/', $subscriberReflection->getName(), $matches);

                $subscriber = new EventSubscriber();
                $subscriber->title = $subscriberReflection->getDocBlock() ? $subscriberReflection->getDocBlock()->getShortDescription() : '';
                $subscriber->code = $subscriberReflection->getShortName();
                $subscriber->fqcn = $subscriberReflection->getName();
                $subscriber->contextCode = $matches[1] ?? '';

                $event->addSubscriber($subscriber);
            }
        }
    }
}