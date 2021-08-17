<?php

declare(strict_types=1);

namespace App\DDDDocs;

class GrabberHelper
{
    public function isClassInContext(string $classFqcn, string $contextCode): bool
    {
        $contextNamespace = sprintf('App\Context\%s', $contextCode);

        return strpos($classFqcn, $contextNamespace) === 0;
    }
}