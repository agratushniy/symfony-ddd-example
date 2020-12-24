<?php

declare(strict_types=1);

namespace App\Context\OrderManagement\Infrastructure;

use App\Context\OrderManagement\Domain\IOrderRepository;
use App\Context\OrderManagement\Domain\Order;
use App\Context\OrderManagement\Domain\OrderId;
use App\Context\Shared\Infrastructure\DoctrineIRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Order findOneBy(array $criteria, array $orderBy = null)
 */
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