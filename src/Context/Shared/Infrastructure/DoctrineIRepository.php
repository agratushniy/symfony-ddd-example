<?php

declare(strict_types=1);

namespace App\Context\Shared\Infrastructure;

use App\Context\Shared\Domain\Contract\IDomainObject;
use App\Context\Shared\Domain\Contract\IId;
use App\Context\Shared\Domain\Contract\IRepository;
use App\Context\Shared\Domain\Error\DatabaseError;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Uid\Uuid;
use Throwable;

abstract class DoctrineIRepository extends ServiceEntityRepository implements IRepository
{
    /**
     * @inheritDoc
     */
    public function persistChanges(IDomainObject $object): void
    {
        $this->do(function () {
            $em = $this->getEntityManager();
            $connection = $em->getConnection();
            $connection->beginTransaction();

            try {
                //TODO можно добавить работу с блокировками
                $em->flush();
                $connection->commit();
            } catch (Throwable $e) {
                $connection->rollBack();

                throw $e;
            }
        });
    }

    /**
     * @inheritDoc
     */
    public function add(IDomainObject $object): void
    {
        if ($this->getEntityManager()->contains($object)) {
            return;
        }

        $this->do(function () use ($object) {
            $this->getEntityManager()->persist($object);
            $this->getEntityManager()->flush();
        });
    }

    public function findAllItems(): Collection
    {
        return new ArrayCollection($this->findAll());
    }

    /**
     * @param callable $operation
     * @return mixed
     * @throws DatabaseError
     */
    protected function do(callable $operation)
    {
        try {
            return $operation();
        } catch (Throwable $e) {
            throw DatabaseError::fromPrevious('Ошибка выполнения операции в БД', $e);
        }
    }
}