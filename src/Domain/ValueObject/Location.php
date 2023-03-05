<?php

namespace Fulll\Domain\ValueObject;

/**
 * class Location
 */
readonly class Location
{
    /**
     * @param string $longitude
     * @param string $latitude
     */
    public function __construct(
        private string $longitude,
        private string $latitude
    ) {
    }

    /**
     * @return string
     */
    public function getLatitude(): string
    {
        return $this->latitude;
    }

    /**
     * @return string
     */
    public function getLongitude(): string
    {
        return $this->longitude;
    }
}
