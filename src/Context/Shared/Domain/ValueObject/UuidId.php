<?php

declare(strict_types=1);

namespace App\Context\Shared\Domain\ValueObject;


use App\Context\Shared\Domain\Contract\IId;
use App\Context\Shared\Domain\SimpleValueObject;
use Ramsey\Uuid\Uuid;

abstract class UuidId extends SimpleValueObject implements IId
{
    public function __construct($value)
    {
        if (preg_match('/^[0-9a-f]{8}-[0-9a-f]{4}-4[0-9a-f]{3}-[89ab][0-9a-f]{3}-[0-9a-f]{12}$/', $value) !== 1) {
            //exception
        }

        parent::__construct($value);
    }

    /**
     * Так делать не стоит. Лучше перенести генерацию идентификаторов в специальный генератор или в репозиторий (в
     * инфраструктурный слой)
     * @return static
     */
    public static function generateNext()
    {
        return static::create(Uuid::uuid1()->toString());
    }

    public function __toString()
    {
        return $this->value;
    }
}