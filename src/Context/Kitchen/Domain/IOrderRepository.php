<?php

declare(strict_types=1);

namespace App\Context\Kitchen\Domain;

use App\Context\Shared\Domain\Contract\IRepository;

interface IOrderRepository extends IRepository
{
    public function findOneById(OrderId $id): ?Order;
}