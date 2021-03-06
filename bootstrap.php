<?php

require 'vendor/autoload.php';

$dotenv = new Dotenv\Dotenv(__DIR__);
$dotenv->load();
$dotenv->required(['NODEDB_USERNAME', 'NODEDB_PASSWORD']);

function dd($x)
{
    die(var_dump($x));
}

$app = new Map\Application();
$app->getContainer()->get(\Illuminate\Database\Capsule\Manager::class);