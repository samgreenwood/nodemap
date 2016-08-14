<?php

namespace Map\Repository;

use Map\Entities\Node;

class NodeRepository
{
    /**
     * NodeRepository constructor.
     * @param array $nodes
     */
    public function __construct(array $nodes = [])
    {
        $this->nodes = $nodes;
    }

    /**
     * @return Node[]
     */
    public function findAll()
    {
        return $this->nodes;
    }
}