<?php

namespace Map;

use Map\Reader\AirStreamXMLReader;
use Slim\Views\Twig;
use DI\Bridge\Slim\App;
use DI\ContainerBuilder;
use Interop\Container\ContainerInterface;

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
                    'cache' => __DIR__ . '/../../cache/templates'
                ]);

                $twig->addExtension(new \Slim\Views\TwigExtension(
                    $c->get('router'),
                    $c->get('request')->getUri()
                ));

                return $twig;
            },
            AirStreamXMLReader::class => function()
            {
                return new AirStreamXMLReader(getenv('NODEDB_USERNAME'), getenv('NODEDB_PASSWORD'));
            },
            'settings.displayErrorDetails' => true,
        ];

        $builder->useAutowiring(true);
        $builder->addDefinitions($definitions);
    }
}