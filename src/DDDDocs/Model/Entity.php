<?php

declare(strict_types=1);

namespace App\DDDDocs\Model;

class Entity
{
    public string $title;
    public string $code;
    public string $fqcn;
    public string $description;
    private array $nodes = [];
    /**
     * @var array|EntityMutator[]
     */
    private array $mutators = [];

    /**
     * @return array
     */
    public function nodes(): array
    {
        return $this->nodes;
    }

    public function addNode(AggregateNode $aggregateNode): void
    {
        $this->nodes[] = $aggregateNode;
    }

    public function addMutator(EntityMutator $mutator): void
    {
        $this->mutators[] = $mutator;
    }

    /**
     * @return array
     */
    public function mutators(): array
    {
        return $this->mutators;
    }

    /**
     * @return array|Event[]
     */
    public function events(): array
    {
        $events = [];

        foreach ($this->mutators as $mutator) {
            $events = array_merge($events, $mutator->events());
        }

        return $events;
    }

    public function findMutator(string $methodName): ?EntityMutator
    {
        foreach ($this->mutators as $mutator) {
            if ($mutator->code === $methodName) {
                return $mutator;
            }
        }

        return null;
    }
}