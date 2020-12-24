<?php

declare(strict_types=1);

namespace App\Context\Shared\Infrastructure\Bus;

use App\Context\Shared\Application\Bus\Command\ICommand;
use App\Context\Shared\Application\Bus\Command\ICommandBus;
use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Symfony\Component\Messenger\MessageBusInterface;

class CommandBus implements ICommandBus
{
    private MessageBusInterface $messageBus;

    public function __construct(MessageBusInterface $messageBus)
    {
        $this->messageBus = $messageBus;
    }

    /**
     * @inheritDoc
     */
    public function dispatch(ICommand $command): void
    {
        /*
         * Посредник Symfony накапливает исключения со всех обработчиков и оборачивает их в собственное исключение
         * Т.к. у нас одна команда = один обработчик, то нам нужно извлечь исключение из обертки и бросить его еще раз
         */
        try {
            $this->messageBus->dispatch($command);
        } catch (HandlerFailedException $e) {
            throw $e->getNestedExceptions()[0];
        }

    }
}