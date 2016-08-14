<?php

namespace Map\Http\Controllers\API;

use Slim\Http\Request;
use Slim\Http\Response;
use Map\Repository\LinkRepository;

class LinkController
{
    /**
     * @var LinkRepository
     */
    private $linkRepository;

    /**
     * LinkController constructor.
     * @param LinkRepository $linkRepository
     */
    public function __construct(LinkRepository $linkRepository)
    {
        $this->linkRepository = $linkRepository;
    }

    /**
     * @param Request $request
     * @param Response $response
     * @return Response
     */
    public function index(Request $request, Response $response)
    {
        $links = $this->linkRepository->findAll();

        return $response->write(json_encode($links));
    }
}
