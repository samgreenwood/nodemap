<?php

$app->get('/', function ($request, $response, $args) {
    return $response->write(file_get_contents('../templates/index.html'));
});

$app->get('/api/nodes', function ($request, $response, $args) use($app) {
    $nodes = $this->nodeRepository->findAll();
    return $response->write(json_encode($nodes));
});

$app->get('/api/links', function ($request, $response, $args) use($app) {
    $links = $this->linkRepository->findAll();
    return $response->write(json_encode($links));
});