<?php

declare(strict_types=1);

namespace App\DDDDocs\Grabber;

use App\Context\Shared\Application\Bus\Command\ICommandHandler;
use App\Context\Shared\Domain\DefaultEntity;
use App\DDDDocs\Annotation\Entity;
use App\DDDDocs\ClassLoader;
use App\DDDDocs\GrabberHelper;
use App\DDDDocs\Model\Context;
use App\DDDDocs\Model\UseCaseEntity;
use Doctrine\Common\Annotations\AnnotationReader;
use Laminas\Code\Reflection\ClassReflection;
use Laminas\Code\Reflection\FileReflection;

class UseCaseEntitiesGrabber implements IGrabber
{
    private ClassLoader $classLoader;
    private AnnotationReader $annotationReader;
    private GrabberHelper $grabberHelper;

    public function __construct(
        ClassLoader $classLoader,
        AnnotationReader $annotationReader,
        GrabberHelper $grabberHelper
    ) {
        $this->classLoader = $classLoader;
        $this->annotationReader = $annotationReader;
        $this->grabberHelper = $grabberHelper;
    }

    public function grab(ClassReflection $classReflection, Context $context): void
    {
        if (!$this->grabberHelper->isClassInContext($classReflection->getName(), $context->code)) {
            return;
        }

        $sourceClasses = $this->classLoader->load();

        foreach ($context->useCases() as $useCase) {
            foreach ($sourceClasses as $handlerClass) {

                if (!class_exists($handlerClass)) {
                    continue;
                }

                $handlerReflection = new ClassReflection($handlerClass);

                if (!$handlerReflection->implementsInterface(ICommandHandler::class)) {
                    continue;
                }

                if (!$handlerReflection->hasMethod('__invoke')) {
                    continue;
                }

                $invokeMethod = $handlerReflection->getMethod('__invoke');
                $invokeParams = $invokeMethod->getParameters();

                if (!isset($invokeParams[0])) {
                    continue;
                }

                $handlerParam = $invokeParams[0];

                if (!$handlerParam->getClass()) {
                    continue;
                }

                if ($handlerParam->getClass()->getName() !== $useCase->fqcn) {
                    continue;
                }

                $handlerFile = new FileReflection($handlerReflection->getFileName());
                $handlerUses = $handlerFile->getUses();

                foreach ($handlerUses as $handlerUsedClass) {
                    if (!class_exists($handlerUsedClass['use'])) {
                        continue;
                    }

                    $handlerUsedClassReflection = new ClassReflection($handlerUsedClass['use']);

                    if (!$handlerUsedClassReflection->isSubclassOf(DefaultEntity::class)) {
                        continue;
                    }

                    /**
                     * @var Entity $usedEntityAnnotation
                     */
                    if (!$this->annotationReader->getClassAnnotation($handlerUsedClassReflection, Entity::class)) {
                        continue;
                    }

                    $entity = new UseCaseEntity();
                    $entity->code = $handlerUsedClassReflection->getShortName();

                    $useCase->addEntity($entity);
                }
            }
        }


    }
}