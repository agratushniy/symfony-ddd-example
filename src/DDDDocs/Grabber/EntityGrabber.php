<?php

declare(strict_types=1);

namespace App\DDDDocs\Grabber;

use App\DDDDocs\Annotation\Entity;
use App\DDDDocs\GrabberHelper;
use App\DDDDocs\Model\Context;
use Doctrine\Common\Annotations\AnnotationReader;
use Laminas\Code\Reflection\ClassReflection;

class EntityGrabber extends CompositeGrabber
{
    private AnnotationReader $annotationReader;
    private GrabberHelper $grabberHelper;

    public function __construct(
        AnnotationReader $annotationReader,
        GrabberHelper $grabberHelper,
        iterable $childGrabbers = []
    ) {
        $this->annotationReader = $annotationReader;
        parent::__construct($childGrabbers);
        $this->grabberHelper = $grabberHelper;
    }

    public function grab(ClassReflection $classReflection, Context $context): void
    {
        if (!$this->grabberHelper->isClassInContext($classReflection->getName(), $context->code)) {
            return;
        }

        /**
         * @var Entity $entityAnnotation
         */
        if (!$entityAnnotation = $this->annotationReader->getClassAnnotation($classReflection, Entity::class)) {
            return;
        }

        $entity = new \App\DDDDocs\Model\Entity();
        $entity->title = $entityAnnotation->name;
        $entity->code = $classReflection->getShortName();
        $entity->fqcn = $classReflection->getName();
        $entity->description = $entityAnnotation->description;

        $context->addEntity($entity);
        $this->runChildGrabbers($classReflection, $context);
    }
}