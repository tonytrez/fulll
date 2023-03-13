<?php

namespace Fulll\Domain\ValueObject;

use Doctrine\ORM\Mapping\Embeddable;

/**
 * class Location
 */
readonly class Location implements \JsonSerializable
{
    /**
     * @param string      $longitude
     * @param string      $latitude
     * @param string|null $altitude
     */
    public function __construct(
        private string  $longitude,
        private string  $latitude,
        private ?string $altitude = null,
    ) {
    }

    /**
     * @param array $data
     *
     * @return static
     */
    public static function createFromArray(array $data): self
    {
        return new self(
            $data['longitude'],
            $data['latitude'],
            $data['altitude'],
        );
    }

    /**
     * @return array
     */
    public function jsonSerialize(): array
    {
        return [
            'longitude' => $this->longitude,
            'latitude'  => $this->latitude,
            'altitude'  => $this->altitude,
        ];
    }
}
