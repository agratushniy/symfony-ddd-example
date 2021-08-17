<?php

declare(strict_types=1);

namespace App\DDDDocs\Grabber;

use App\DDDDocs\Annotation\AggregateNode;
use App\DDDDocs\Annotation\Entity;
use App\DDDDocs\Model\Context;
use Doctrine\Common\Annotations\AnnotationReader;
use Laminas\Code\Reflection\ClassReflection;

class AggregateNodeGrabber implements IGrabber
{
    private AnnotationReader $annotationReader;

    public function __construct(AnnotationReader $annotationReader)
    {
        $this->annotationReader = $annotationReader;
    }

    public function grab(ClassReflection $classReflection, Context $context): void
    {
        if (!$entity = $context->findEntityByFQCN($classReflection->getName())) {
            return;
        }

        foreach ($classReflection->getProperties() as $propertyReflection) {
            /**
             * @var AggregateNode $aggregateNodeAnnotation
             */
            if (!$aggregateNodeAnnotation = $this->annotationReader->getPropertyAnnotation($propertyReflection,
                AggregateNode::class)) {
                continue;
            }

            if (!class_exists($aggregateNodeAnnotation->class)) {
                continue;
            }

            $nodeClassReflection = new ClassReflection($aggregateNodeAnnotation->class);
            /**
             * @var Entity $nodeEntityAnnotation
             */
            if (!$nodeEntityAnnotation = $this->annotationReader->getClassAnnotation($nodeClassReflection,
                Entity::class)) {
                continue;
            }

            $aggregateNode = new \App\DDDDocs\Model\AggregateNode();
            $aggregateNode->title = $nodeEntityAnnotation->name;
            $aggregateNode->code = $nodeClassReflection->getShortName();

            $entity->addNode($aggregateNode);
        }
    }
}