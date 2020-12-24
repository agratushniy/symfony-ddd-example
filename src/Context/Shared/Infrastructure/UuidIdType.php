<?php

declare(strict_types=1);

namespace App\Context\Shared\Infrastructure;


use App\Context\Shared\Domain\ValueObject\UuidId;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\ConversionException;
use Doctrine\DBAL\Types\Type;

abstract class UuidIdType extends Type
{
    protected const NAME = '';

    public function getName()
    {
        return self::NAME;
    }

    public function getSQLDeclaration(array $column, AbstractPlatform $platform)
    {
        return $platform->getGuidTypeDeclarationSQL($column);
    }

    /**
     * {@inheritdoc}
     *
     * @param string|null      $value
     * @param AbstractPlatform $platform
     *
     * @throws ConversionException
     */
    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        if (empty($value)) {
            return null;
        }

        /**
         * @var UuidId $className
         */
        $className = $this->className();

        if ($value instanceof $className) {
            return $value;
        }

        try {
            $uuid = $className::create($value);
        } catch (\InvalidArgumentException $e) {
            throw ConversionException::conversionFailed($value, static::NAME);
        }

        return $uuid;
    }

    /**
     * {@inheritdoc}
     *
     * @param UuidId|null      $value
     * @param AbstractPlatform $platform
     *
     * @throws ConversionException
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        if (empty($value)) {
            return null;
        }

        if ($value instanceof UuidId) {
            return $value->value();
        }

        throw ConversionException::conversionFailed($value, static::NAME);
    }

    /**
     * @return string
     */
    abstract protected function className(): string;
}