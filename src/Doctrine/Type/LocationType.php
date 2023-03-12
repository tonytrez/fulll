<?php

namespace Fulll\Doctrine\Type;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;
use Fulll\Domain\ValueObject\Location;

class LocationType extends Type
{
    const TYPE = 'location_type';

    /**
     * @param array            $column
     * @param AbstractPlatform $platform
     *
     * @return string
     */
    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        return $platform->getJsonTypeDeclarationSQL($column);
    }

    /**
     * @throws \Exception
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform): string|null|false
    {
        if ($value === null) {
            return null;
        }

        if (!$value instanceof Location) {
            throw new \Exception('Only App\\Entity\\ValueObject\\Location object is supported.');
        }

        return json_encode($value->jsonSerialize());
    }

    /**
     * @param                  $value
     * @param AbstractPlatform $platform
     *
     * @return Location|null
     */
    public function convertToPHPValue($value, AbstractPlatform $platform): ?Location
    {
        if ($value === null) {
            return null;
        }

        $data = json_decode($value, true);

        return Location::createFromArray($data);
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return self::TYPE;
    }
}
