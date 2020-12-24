<?php

declare(strict_types=1);

namespace App\Context\Shared\Infrastructure\Bus;

use App\Context\Shared\Application\Bus\Query\IQuery;
use App\Context\Shared\Application\Bus\Query\IQueryBus;
use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;

class QueryBus implements IQueryBus
{
    use HandleTrait;

    public function __construct(MessageBusInterface $messageBus)
    {
        $this->messageBus = $messageBus;
    }

    /**
     * @inheritDoc
     */
    public function ask(IQuery $query)
    {
        /*
         * Посредник Symfony накапливает исключения со всех обработчиков и оборачивает их в собственное исключение
         * Т.к. у нас один запрос = один обработчик, то нам нужно извлечь исключение из обертки и бросить его еще раз
         */
        try {
            return $this->handle($query);
        } catch (HandlerFailedException $e) {
            throw $e->getNestedExceptions()[0];
        }
    }
}