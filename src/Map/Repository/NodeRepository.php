<?php

namespace Map\Repository;

use Map\Entities\Coordinates;
use Map\Entities\Node;
use SimpleXMLElement;

class NodeRepository
{
    /**
     * @var SimpleXMLElement
     */
    private $data;

    /**
     * NodeRepository constructor.
     * @param SimpleXMLElement $data
     */
    public function __construct(SimpleXMLElement $data)
    {
        $this->data = $data;
    }

    /**
     * @return Node[]
     */
    public function findAll()
    {
        $data = (array) $this->data;
        $data = array_pop($data);

        return array_combine(array_map(function($node) {
            return $node['id'];
        }, $data), array_map(function($node) {
            $coordinates = new Coordinates((float) $node['lat'], (float) $node['lon']);
            return new Node((integer) $node['id'], (string) $node['name'], $coordinates);
        }, $data));

    }
}