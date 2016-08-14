<?php

namespace Map\Repository;

use Map\Entities\Link;

class LinkRepository
{
    /**
     * @var array
     */
    private $links;

    /**
     * LinkRepository constructor.
     * @param $links
     */
    public function __construct(array $links = [])
    {
        $this->links = $links;
    }

    /**
     * @return Link[]
     */
    public function findAll()
    {
        return $this->links;
    }

    /**
     * @param int $nodeId
     * @return array
     */
    public function findByNodeId(int $nodeId)
    {
        return array_filter($this->links, function (Link $link) use ($nodeId) {
            return $link->getDestination()->getId() == $nodeId || $link->getSource()->getId() == $nodeId;
        });
    }
}
