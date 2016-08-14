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
     * @var bool
     */
    private $accessPoint;

    /**
     * Node constructor.
     * @param int $id
     * @param string $name
     * @param Coordinates $coordinates
     * @param bool $accessPoint
     */
    public function __construct(int $id, string $name, Coordinates $coordinates, bool $accessPoint)
    {
        $this->id = $id;
        $this->name = $name;
        $this->coordinates = $coordinates;
        $this->accessPoint = $accessPoint;
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
           'accessPoint' => $this->accessPoint
       ];
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return Coordinates
     */
    public function getCoordinates(): Coordinates
    {
        return $this->coordinates;
    }

}