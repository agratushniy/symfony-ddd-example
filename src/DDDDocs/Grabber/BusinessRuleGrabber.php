<?php

declare(strict_types=1);

namespace App\DDDDocs\Grabber;

use App\DDDDocs\Annotation\BusinessRule;
use App\DDDDocs\ContentDockBlockScanner;
use App\DDDDocs\Model\Context;
use Doctrine\Common\Annotations\Annotation\Target;
use Doctrine\Common\Annotations\DocParser;
use Laminas\Code\Reflection\ClassReflection;

class BusinessRuleGrabber implements IGrabber
{
    public function grab(ClassReflection $classReflection, Context $context): void
    {
        if (!$entity = $context->findEntityByFQCN($classReflection->getName())) {
            return;
        }

        $docParser = new DocParser();
        $docParser->setTarget(Target::TARGET_ANNOTATION);
        $docParser->setImports([
            'businessrule' => BusinessRule::class
        ]);

        foreach ($classReflection->getMethods() as $methodReflection) {

            $methodName = $methodReflection->getName();

            if (!$entityMutator = $entity->findMutator($methodName)) {
                continue;
            }

            $methodContent = $methodReflection->getContents();
            $scanner = new ContentDockBlockScanner($methodContent);
            $blocks = $scanner->getDocBlocks();

            foreach ($blocks as $block) {
                /**
                 * @var BusinessRule[] $ruleAnnotations
                 */
                $ruleAnnotations = $docParser->parse($block);

                foreach ($ruleAnnotations as $annotation) {

                    $rule = new \App\DDDDocs\Model\BusinessRule();
                    $rule->title = $annotation->title;
                    $rule->description = $annotation->description;

                    $entityMutator->addRule($rule);
                }

            }
        }

    }
}