<?php

require 'vendor/autoload.php';

function dd($x)
{
    die(var_dump($x));
}

$container = new \Slim\Container;

$data = new SimpleXMLElement(file_get_contents('../nodes.xml'));

$container['nodeRepository'] = new \Map\Repository\NodeRepository($data);
$container['linkRepository'] = new \Map\Repository\LinkRepository($data, $container['nodeRepository']);