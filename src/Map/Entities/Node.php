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
     * @var string
     */
    private $status;

    /**
     * Node constructor.
     * @param int $id
     * @param string $name
     * @param Coordinates $coordinates
     * @param bool $accessPoint
     */
    public function __construct(int $id, string $name, Coordinates $coordinates, bool $accessPoint, string $status)
    {
        $this->id = $id;
        $this->name = $name;
        $this->coordinates = $coordinates;
        $this->accessPoint = $accessPoint;
        $this->status = $status;
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
           'accessPoint' => $this->accessPoint,
           'status' => $this->status
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

    /**
     * @return boolean
     */
    public function isAccessPoint(): bool
    {
        return $this->accessPoint;
    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }
}
