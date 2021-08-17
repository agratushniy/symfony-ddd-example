<?php

declare(strict_types=1);

namespace App\DDDDocs\Grabber;

use App\Context\Shared\Application\Bus\Command\ICommand;
use App\DDDDocs\GrabberHelper;
use App\DDDDocs\Model\Context;
use App\DDDDocs\Model\UseCase;
use App\DDDDocs\Model\UseCaseParameter;
use Laminas\Code\Reflection\ClassReflection;

class UseCaseGrabber extends CompositeGrabber
{
    private GrabberHelper $grabberHelper;

    public function __construct(GrabberHelper $grabberHelper, iterable $childGrabbers = [])
    {
        parent::__construct($childGrabbers);
        $this->grabberHelper = $grabberHelper;
    }

    public function grab(ClassReflection $classReflection, Context $context): void
    {
        if (!$this->grabberHelper->isClassInContext($classReflection->getName(), $context->code)) {
            return;
        }

        if (!$classReflection->implementsInterface(ICommand::class) || !$classReflection->isInstantiable()) {
            return;
        }

        $useCase = new UseCase();
        $useCase->title = $classReflection->getDocBlock() ? $classReflection->getDocBlock()->getShortDescription() : '';
        $useCase->code = $classReflection->getShortName();
        $useCase->fqcn = $classReflection->getName();

        foreach ($classReflection->getProperties() as $commandPropertyReflection) {

            $useCaseParameter = new UseCaseParameter();
            $useCaseParameter->title = $commandPropertyReflection->getDocBlock() ? $commandPropertyReflection->getDocBlock()->getShortDescription() : '';
            $useCaseParameter->code = $commandPropertyReflection->getName();

            $useCase->addParameter($useCaseParameter);
        }

        $context->addUseCase($useCase);
        $this->runChildGrabbers($classReflection, $context);
    }
}