<?php

namespace Map\Http\Controllers;

use Doctrine\Common\Cache\Cache;
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
     * @var Cache
     */
    private $cache;

    /**
     * MapController constructor.
     * @param Twig $twig
     * @param Cache $cache
     */
    public function __construct(Twig $twig, Cache $cache)
    {
        $this->twig = $twig;
        $this->cache = $cache;
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

    /**
     * @param Request $request
     * @param Response $response
     * @return static
     */
    public function clearCache(Request $request, Response $response)
    {
        $this->cache->delete('nodes');

        return $response
            ->withStatus(302)
            ->withHeader('Location', (string) '/');
    }
}
