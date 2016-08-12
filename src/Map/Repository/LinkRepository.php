<?php

namespace Map\Repository;

use Map\Entities\Link;
use Map\Entities\Node;
use SimpleXMLElement;

class LinkRepository
{
    /**
     * @var SimpleXMLElement
     */
    private $data;

    /**
     * @var NodeRepository
     */
    private $nodeRepository;

    /**
     * LinkRepository constructor.
     * @param SimpleXMLElement $data
     * @param NodeRepository $nodeRepository
     */
    public function __construct(SimpleXMLElement $data, NodeRepository $nodeRepository)
    {
        $this->nodeRepository = $nodeRepository;
        $this->data = $data;
    }

    /**
     * @return Node[]
     */
    public function findAll()
    {
        $data = (array) $this->data;
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