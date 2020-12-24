<?php

declare(strict_types=1);

namespace App\Context\OrderManagement\Application\Query\Dto;

class OrderDto
{
    public string $id;
    public array $items;
    public string $status;
}