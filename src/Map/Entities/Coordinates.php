<?php

namespace Map\Entities;

use JsonSerializable;

class Coordinates implements JsonSerializable
{
    /**
     * @var int
     */
    private $lat;

    /**
     * @var int
     */
    private $lng;

    /**
     * Coordinates constructor.
     * @param float $lat
     * @param float $lng
     */
    public function __construct(float $lat, float $lng)
    {
        $this->lat = $lat;
        $this->lng = $lng;
    }

    /**
     * @return double
     */
    public function getLat() : float
    {
        return $this->lat;
    }

    /**
     * @return double
     */
    public function getLng() : float
    {
        return $this->lng;
    }

    /**
     * @return array
     */
    public function jsonSerialize()
    {
        return [
            'lat' => $this->lat,
            'lng' => $this->lng,
        ];
    }
}
