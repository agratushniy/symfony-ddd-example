<?php

declare(strict_types=1);

namespace App\Context\Shared\Application\Bus\Query;

/**
 * Шина запросов
 */
interface IQueryBus
{
    /**
     * Сделать запрос
     * @param IQuery $query
     * @return mixed
     */
    public function ask(IQuery $query);
}