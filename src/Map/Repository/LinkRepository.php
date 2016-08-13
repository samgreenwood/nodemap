<?php

namespace Map\Repository;

use Map\Entities\Link;
use Map\Entities\Node;
use Map\Reader\AirStreamXMLReader;

class LinkRepository
{
    /**
     * @var AirStreamXMLReader
     */
    private $reader;

    /**
     * @var NodeRepository
     */
    private $nodeRepository;

    /**
     * LinkRepository constructor.
     * @param AirStreamXMLReader $reader
     * @param NodeRepository $nodeRepository
     */
    public function __construct(AirStreamXMLReader $reader, NodeRepository $nodeRepository)
    {
        $this->reader = $reader;
        $this->nodeRepository = $nodeRepository;
    }

    /**
     * @return Node[]
     */
    public function findAll()
    {
        $data = (array) $this->reader->read();
        $data = array_pop($data);

        $nodes = $this->nodeRepository->findAll();

        $links = [];

        foreach($data as $node)
        {
            foreach((array) $node->link as $link)
            {
                $links[] = new Link(
                    $nodes[(string) $node['id']],
                    $nodes[(string) $link['dstnode']],
                    $link['mode'],
                    $link['type']
                );
            }
        }

        return $links;
    }
}