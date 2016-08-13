<?php

namespace Map\Http\Controllers\API;

use Slim\Http\Request;
use Slim\Http\Response;
use Map\Repository\NodeRepository;

class NodeController
{
    /**
     * @var NodeRepository
     */
    private $nodeRepository;

    /**
     * NodeController constructor.
     * @param NodeRepository $nodeRepository
     */
    public function __construct(NodeRepository $nodeRepository)
    {
        $this->nodeRepository = $nodeRepository;
    }

    /**
     * @param Request $request
     * @param Response $response
     * @return Response
     */
    public function index(Request $request, Response $response)
    {
        $nodes = $this->nodeRepository->findAll();

        return $response->write(json_encode($nodes));
    }
}