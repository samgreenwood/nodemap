<?php

namespace Map\Middleware;

use Map\Auth\Authenticator;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class Authenticated
{
    /**
     * @var Authenticator
     */
    private $auth;

    /**
     * Authenticated constructor.
     * @param Authenticator $auth
     */
    public function __construct(Authenticator $auth)
    {
        $this->auth = $auth;
    }

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param callable $next
     * @return static
     */
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, callable $next)
    {
        if (!$this->auth->authenticated()) {
            return $response
                ->withStatus(302)
                ->withHeader('Location', (string) '/login');
        }

        return $next($request, $response);
    }
}
