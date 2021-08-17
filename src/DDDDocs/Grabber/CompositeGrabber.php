<?php

declare(strict_types=1);

namespace App\DDDDocs\Grabber;

use App\DDDDocs\Model\Context;
use Laminas\Code\Reflection\ClassReflection;

abstract class CompositeGrabber implements IGrabber
{
    /**
     * @var iterable|IGrabber[]
     */
    protected iterable $childGrabbers;

    public function __construct(iterable $childGrabbers = [])
    {
        $this->childGrabbers = $childGrabbers;
    }

    protected function runChildGrabbers(ClassReflection $classReflection, Context $context): void
    {
        foreach ($this->childGrabbers as $grabber) {
            $grabber->grab($classReflection, $context);
        }
    }
}