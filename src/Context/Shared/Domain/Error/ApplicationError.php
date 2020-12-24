<?php

declare(strict_types=1);

namespace App\Context\Shared\Domain\Error;

use Exception;
use Throwable;

/**
 * Базовая ошибка для приложения
 */
class ApplicationError extends Exception
{
    /**
     * Создать ошибку
     * @return ApplicationError
     */
    public static function create()
    {
        return new static();
    }

    /**
     * Ошибка с указанием сообщения
     * @param string $message
     * @return ApplicationError
     */
    public static function withMessage(string $message)
    {
        return new static($message);
    }

    /**
     * Ошибка с ссылкой на предыдущую ошибку
     * @param string $message
     * @param Throwable|null $previous
     * @return  static
     */
    public static function fromPrevious(string $message, Throwable $previous = null)
    {
        return new static($message, 0, $previous);
    }
}