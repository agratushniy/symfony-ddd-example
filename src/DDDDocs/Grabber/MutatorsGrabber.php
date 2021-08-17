<?php

declare(strict_types=1);

namespace App\DDDDocs\Grabber;

use App\DDDDocs\Model\Context;
use App\DDDDocs\Model\EntityMutator;
use Laminas\Code\Reflection\ClassReflection;

class MutatorsGrabber implements IGrabber
{

    public function grab(ClassReflection $classReflection, Context $context): void
    {
        if (!$entity = $context->findEntityByFQCN($classReflection->getName())) {
            return;
        }

        foreach ($classReflection->getMethods() as $methodReflection) {
            if (!$methodReflection->isPublic()) {
                continue;
            }

            if ($methodReflection->getName() !== '__construct') {
                if (!$methodReturnType = $methodReflection->getReturnType()) {
                    continue;
                }

                $returnTypeName = $methodReturnType->getName();

                if ($returnTypeName !== 'void') {
                    continue;
                }
            }

            $mutator = new EntityMutator();
            $mutator->code = $methodReflection->getName();
            $mutator->title = $methodReflection->getDocBlock() ? $methodReflection->getDocBlock()->getShortDescription() : '';

            $entity->addMutator($mutator);
        }
    }
}