<?php

declare(strict_types=1);

namespace App\Context\Shared\Domain;

use App\Context\Shared\Domain\Contract\IDomainObject;

/**
 * Объект-заничение описывающий скалярную величину
 *
 * Class SimpleValueObject
 * @package Hans\Shared\Domain\Model
 */
abstract class SimpleValueObject extends DefaultValueObject
{
    protected $value;

    protected function __construct($value)
    {
        $this->value = $value;
    }

    /**
     * Создать объект-значение
     * @param $value
     * @return static
     */
    public static function create($value)
    {
        return new static($value);
    }

    /**
     * @return mixed
     */
    public function value()
    {
        return $this->value;
    }

    /**
     * @param IDomainObject $object
     *
     * @return bool
     */
    public function equals(IDomainObject $object): bool
    {
        /**
         * @var static $object
         */
        return $object->sameTypeAs($object) && $object->value() === $this->value();
    }
}