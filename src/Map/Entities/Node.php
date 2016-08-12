<?php

namespace Map\Entities;

use JsonSerializable;

class Node implements JsonSerializable
{
    /**
     * @var int
     */
    protected $id;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var Coordinates
     */
    protected $coordinates;

    /**
     * Node constructor.
     * @param $name
     * @param Coordinates $coordinates
     */
    public function __construct(int $id, string $name, Coordinates $coordinates)
    {
        $this->id = $id;
        $this->name = $name;
        $this->coordinates = $coordinates;
    }

    /**
     * @return array
     */
    public function jsonSerialize()
    {
       return [
           'id' => $this->id,
           'name' => $this->name,
           'coordinates' => $this->coordinates,
       ];
    }
}