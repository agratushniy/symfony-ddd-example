<?php

declare(strict_types=1);

namespace App\Context\Shared\Domain\Contract;

use App\Context\Shared\Domain\Error\DatabaseError;
use Doctrine\Common\Collections\Collection;

/**
 * Репозиторий
 */
interface IRepository
{
    /**
     * Сохранить изменения объекта
     *
     * Изменения сохраняются в БД в рамках транзакции
     * @param IDomainObject $object
     * @throws DatabaseError
     */
    public function persistChanges(IDomainObject $object): void;

    /**
     * Добавить объект в репозиторий
     * @param IDomainObject $object
     * @throws DatabaseError
     */
    public function add(IDomainObject $object): void;

    public function findAllItems(): Collection;
}