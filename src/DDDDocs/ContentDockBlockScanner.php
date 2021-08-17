<?php

declare(strict_types=1);

namespace App\DDDDocs;

use Laminas\Code\Scanner\TokenArrayScanner;

class ContentDockBlockScanner extends TokenArrayScanner
{
    public function __construct(string $content)
    {
        parent::__construct(token_get_all('<?php ' . $content . ' ?>'));
    }

    public function getDocBlocks(): array
    {
        $blocks = [];

        foreach ($this->tokens as $k => $token) {

            if (!isset($token[1])) {
                continue;
            }

            if (strpos($token[1], 'BusinessRule') === false) {
                continue;
            }

            $blocks[] = $token[1];
        }

        return $blocks;
    }
}