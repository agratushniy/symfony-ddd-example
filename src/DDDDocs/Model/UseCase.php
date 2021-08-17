<?php

declare(strict_types=1);

namespace App\DDDDocs\Model;

class UseCase
{
    public string $title;
    public string $code;
    public string $fqcn;
    private array $entities = [];
    private array $parameters = [];

    /**
     * @return array|UseCaseParameter[]
     */
    public function parameters(): array
    {
        return $this->parameters;
    }

    public function addParameter(UseCaseParameter $parameter): void
    {
        $this->parameters[] = $parameter;
    }

    public function addEntity(UseCaseEntity $useCaseEntity): void
    {
        foreach ($this->entities() as $entity) {
            if ($entity->code === $useCaseEntity->code) {
                return;
            }
        }

        $this->entities[] = $useCaseEntity;
    }

    /**
     * @return array|UseCaseEntity[]
     */
    public function entities(): array
    {
        return $this->entities;
    }
}