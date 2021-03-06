<?php

namespace Map\Http\Controllers;

use Map\Auth\Authenticator;
use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Views\Twig;

class AuthController
{
    /**
     * @var Twig
     */
    private $twig;

    /**
     * @var LDAPAuthenticator
     */
    private $auth;

    /**
     * AuthController constructor.
     * @param Twig $twig
     * @param Authenticator $auth
     */
    public function __construct(Twig $twig, Authenticator $auth)
    {
        $this->twig = $twig;
        $this->auth = $auth;
    }

    /**
     * @param Request $request
     * @param Response $response
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function getLogin(Request $request, Response $response)
    {
        return $this->twig->render($response, 'auth/login.twig');
    }

    /**
     * @param Request $request
     * @param Response $response
     * @return static
     */
    public function postLogin(Request $request, Response $response)
    {
        $auth = $this->auth->attempt($request->getParam('username'), $request->getParam('password'));

        if (!$auth) {
            return $response->withRedirect('/login');
        }

        return $response->withRedirect('/');
    }

    /**
     * @param Request $request
     * @param Response $response
     * @return static
     */
    public function getLogout(Request $request, Response $response)
    {
        $this->auth->logout();

        return $response->withRedirect('/');
    }
}
