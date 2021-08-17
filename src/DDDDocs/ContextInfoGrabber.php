<?php

declare(strict_types=1);

namespace App\DDDDocs;

use App\DDDDocs\Model\Context;

class ContextInfoGrabber
{
    private string $contextsPath;

    public function __construct(string $contextsPath)
    {
        $this->contextsPath = $contextsPath;
    }

    /**
     * @param string $contextCode
     * @return Context|null
     * @throws \JsonException
     */
    public function getContextInfo(string $contextCode): ?Context
    {
        $descriptionPath = $this->contextsPath . '/' . $contextCode . '/context.json';

        if (!is_readable($descriptionPath)) {
            return null;
        }

        $jsonContent = file_get_contents($descriptionPath);
        $contextData = json_decode($jsonContent, true, 512, JSON_THROW_ON_ERROR);

        $context = new Context();
        $context->title = $contextData['title'];
        $context->description = $contextData['description'];
        $context->code = $contextCode;

        return $context;
    }
}