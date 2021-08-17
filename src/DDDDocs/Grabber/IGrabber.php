<?php

declare(strict_types=1);

namespace App\DDDDocs\Grabber;

use App\DDDDocs\Model\Context;
use Laminas\Code\Reflection\ClassReflection;

interface IGrabber
{
    public function grab(ClassReflection $classReflection, Context $context): void;
}