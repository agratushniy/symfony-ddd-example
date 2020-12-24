<?php
declare(strict_types=1);

namespace App\Context\Shared\Domain\ValueObject;

/**
 * Деньги
 */
class Money extends PositiveIntegerValue
{
    /**
     * Значение в рублях
     * @return int
     */
    public function roubles(): int
    {
        return (int)round($this->value() / 100, 0);
    }

    /**
     * @param int $cents копейки
     * @return Money
     */
    public static function fromCents(int $cents): self
    {
        return new self($cents);
    }

    /**
     * @return Money
     */
    public static function zero(): self
    {
        return new self(0);
    }

    /**
     * Создать из рублей
     * @param int $roubles
     * @return Money
     */
    public static function fromRoubles(int $roubles): self
    {
        return new self($roubles * 100);
    }
}