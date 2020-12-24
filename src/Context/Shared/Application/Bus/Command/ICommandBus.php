<?php

declare(strict_types=1);

namespace App\Context\Shared\Application\Bus\Command;

use App\Context\Shared\Domain\Error\ApplicationError;

/**
 * Шина команд
 */
interface ICommandBus
{
    /**
     * Отправить команду
     *
     * @param ICommand $command
     * @throws ApplicationError
     */
    public function dispatch(ICommand $command): void;
}