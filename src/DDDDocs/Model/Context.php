<?php

declare(strict_types=1);

namespace App\DDDDocs\Model;

class Context
{
    public string $title;
    public string $description;
    public string $code;
    /**
     * @var array|Entity[]
     */
    private array $entities = [];
    private array $useCases = [];

    public function addEntity(Entity $entity): void
    {
        $this->entities[] = $entity;
    }

    /**
     * @return array|Entity[]
     */
    public function entities(): array
    {
        return $this->entities;
    }

    public function findEntityByFQCN(string $fqcn): ?Entity
    {
        foreach ($this->entities as $entity) {
            if ($entity->fqcn === $fqcn) {
                return $entity;
            }
        }

        return null;
    }

    /**
     * @return array|UseCase[]
     */
    public function useCases(): array
    {
        return $this->useCases;
    }

    public function addUseCase(UseCase $useCase): void
    {
        $this->useCases[] = $useCase;
    }
}