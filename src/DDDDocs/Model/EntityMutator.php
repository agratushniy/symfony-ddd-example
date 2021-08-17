<?php

declare(strict_types=1);

namespace App\DDDDocs\Model;

class EntityMutator
{
    public string $title;
    public string $code;
    public array $rules = [];
    public array $events = [];

    /**
     * @return array
     */
    public function rules(): array
    {
        return $this->rules;
    }

    public function addRule(BusinessRule $rule): void
    {
        $this->rules[] = $rule;
    }

    /**
     * @return array
     */
    public function events(): array
    {
        return $this->events;
    }

    public function addEvent(Event $event): void
    {
        $this->events[] = $event;
    }
}