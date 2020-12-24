<?php

declare(strict_types=1);

namespace App\Context\OrderManagement\Application\Query\Dto;

/**
 * Элемент заказа
 */
class OrderItemDto
{
    public string $id;
    public string $title;
    public int $price;
    public int $quantity;
}