<?php

namespace Map\Http\Controllers;

use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Views\Twig;

class MapController
{
    /**
     * @var Twig
     */
    private $twig;

    /**
     * MapController constructor.
     * @param Twig $twig
     */
    public function __construct(Twig $twig)
    {
        $this->twig = $twig;
    }

    /**
     * @param Request $request
     * @param Response $response
     * @return mixed
     */
    public function index(Request $request, Response $response)
    {
        return $this->twig->render($response, 'map/index.twig');
    }
}
