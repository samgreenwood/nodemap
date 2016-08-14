<?php

namespace Map;

use Map\Auth\Adapters\StaticAdapter;
use Map\Auth\Authenticator;
use Map\Auth\StaticAuthenticator;
use Map\Repository\LinkRepository;
use Map\Repository\NodeRepository;
use Slim\Views\Twig;
use DI\Bridge\Slim\App;
use DI\ContainerBuilder;
use Map\Reader\AirStreamXMLReader;
use Interop\Container\ContainerInterface;
use Doctrine\Common\Cache\FilesystemCache;
use Zend\Authentication\AuthenticationService;
use Zend\Authentication\AuthenticationServiceInterface;
use Zend\Authentication\Storage\Session;

class Application extends App
{
    /**
     * @param ContainerBuilder $builder
     */
    protected function configureContainer(ContainerBuilder $builder)
    {
        $definitions = [
            Twig::class => function (ContainerInterface $c) {
                $twig = new Twig(__DIR__ . '/../../templates', [
                    'cache' => __DIR__ . '/../../cache/templates',
                    'auto_reload' => true
                ]);

                $twig->addExtension(new \Slim\Views\TwigExtension(
                    $c->get('router'),
                    $c->get('request')->getUri()
                ));

                return $twig;
            },
            AirStreamXMLReader::class => function()
            {
                $cache = new FilesystemCache( __DIR__ . '/../../cache/application');
                return new AirStreamXMLReader(getenv('NODEDB_USERNAME'), getenv('NODEDB_PASSWORD'), $cache);
            },
            NodeRepository::class => function(ContainerInterface $c)
            {
                $data = $c->get(AirStreamXMLReader::class)->nodes();
                return new NodeRepository($data);
            },
            LinkRepository::class => function(ContainerInterface $c)
            {
                $data = $c->get(AirStreamXMLReader::class)->links();
                return new LinkRepository($data);
            },
            AuthenticationServiceInterface::class => function(ContainerInterface $c)
            {
                $authenticationService = new AuthenticationService();
                $authenticationService->setStorage($c->get(Session::class));
                $authenticationService->setAdapter($c->get(getenv('AUTH_ADAPTER') ?: StaticAdapter::class));

                return $authenticationService;
            },
            'settings.displayErrorDetails' => true,
            'settings.determineRouteBeforeAppMiddleware' => true
        ];

        $builder->useAutowiring(true);
        $builder->addDefinitions($definitions);
    }
}