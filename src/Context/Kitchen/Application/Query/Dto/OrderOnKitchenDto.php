<?php

declare(strict_types=1);

namespace App\Context\Kitchen\Application\Query\Dto;

/**
 * Заказ на кухне
 */
class OrderOnKitchenDto
{
    public string $id;
    /**
     * @var DishDto[]
     */
    public array $dishes;
}