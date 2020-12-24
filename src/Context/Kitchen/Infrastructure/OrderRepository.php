<?php

declare(strict_types=1);

namespace App\Context\Kitchen\Infrastructure;

use App\Context\Kitchen\Domain\IOrderRepository;
use App\Context\Kitchen\Domain\Order;
use App\Context\Kitchen\Domain\OrderId;
use App\Context\Shared\Infrastructure\DoctrineIRepository;
use Doctrine\Persistence\ManagerRegistry;

class OrderRepository extends DoctrineIRepository implements IOrderRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Order::class);
    }

    public function findOneById(OrderId $id): ?Order
    {
        return $this->findOneBy(['id' => $id]);
    }
}