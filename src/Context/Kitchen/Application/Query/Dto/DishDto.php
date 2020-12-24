<?php

declare(strict_types=1);

namespace App\Context\Kitchen\Application\Query\Dto;

/**
 * Блюдо для приготовления
 */
class DishDto
{
    public string $id;
    public string $title;
    public bool $cooked;
}