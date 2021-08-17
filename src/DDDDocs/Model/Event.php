<?php

declare(strict_types=1);

namespace App\DDDDocs\Model;

class Event
{
    public string $title;
    public string $code;
    public string $fqcn;
    public array $subscribers = [];

    /**
     * @return array
     */
    public function subscribers(): array
    {
        return $this->subscribers;
    }

    public function addSubscriber(EventSubscriber $subscriber): void
    {
        $this->subscribers[] = $subscriber;
    }
}