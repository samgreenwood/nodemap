<?php

namespace Map\Entities;

class Link implements \JsonSerializable
{
    /**
     * @var Node
     */
    private $source;

    /**
     * @var Node
     */
    private $destination;

    /**
     * @var integer
     */
    private $frequency;

    /**
     * @var string
     */
    private $type;

    /**
     * Link constructor.
     * @param Node $source
     * @param Node $destination
     * @param $frequency
     * @param $type
     */
    public function __construct(Node $source, Node $destination, string $frequency, string $type)
    {
        $this->source = $source;
        $this->destination = $destination;
        $this->frequency = $frequency;
        $this->type = $type;
    }

    /**
     * @return Node
     */
    public function getSource() : Node
    {
        return $this->source;
    }

    /**
     * @return Node
     */
    public function getDestination() : Node
    {
        return $this->destination;
    }

    /**
     * @return int
     */
    public function getFrequency(): int
    {
        return $this->frequency;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @return array
     */
    function jsonSerialize()
    {
       return [
           'source' => $this->source,
           'destination' => $this->destination,
           'frequency' => $this->frequency,
           'type' => $this->type
       ];
    }
}