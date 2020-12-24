<?php

declare(strict_types=1);

namespace App\Context\Kitchen\Domain;

use App\Context\Shared\Domain\DefaultEntity;
use App\Context\Shared\Domain\ValueObject\Title;

class Dish extends DefaultEntity
{
    private Title $title;
    private bool $cooked;

    public function __construct(DishId $id, Title $title)
    {
        $this->id = $id;
        $this->title = $title;
        $this->cooked = false;
    }

    /**
     * Приготовить блюдо
     */
    public function cookingComplete(): void
    {
        $this->cooked = true;
    }

    /**
     * @return Title
     */
    public function title(): Title
    {
        return $this->title;
    }

    /**
     * @return bool
     */
    public function cooked(): bool
    {
        return $this->cooked;
    }
}