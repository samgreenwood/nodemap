<?php

namespace Map\Repository;

use Map\Entities\Coordinates;
use Map\Entities\Node;
use Map\Reader\AirStreamXMLReader;

class NodeRepository
{
    /**
     * @var AirStreamXMLReader
     */
    private $reader;

    /**
     * NodeRepository constructor.
     * @param AirStreamXMLReader $reader
     */
    public function __construct(AirStreamXMLReader $reader)
    {
        $this->reader = $reader;
    }

    /**
     * @return Node[]
     */
    public function findAll()
    {
        $data = (array) $this->reader->read();
        $data = array_pop($data);

        return array_combine(array_map(function($node) {
            return $node['id'];
        }, $data), array_map(function($node) {
            $coordinates = new Coordinates((float) $node['lat'], (float) $node['lon']);
            return new Node((integer) $node['id'], (string) $node['name'], $coordinates);
        }, $data));

    }
}