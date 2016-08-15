<?php

$app->group('', function () {
    $this->get('/login', [\Map\Http\Controllers\AuthController::class, 'getLogin']);
    $this->post('/login', [\Map\Http\Controllers\AuthController::class, 'postLogin']);
})->add($app->getContainer()->get(\Map\Middleware\RedirectIfAuthenticated::class));;

$app->group('', function () {
    $this->get('/', [\Map\Http\Controllers\MapController::class, 'index']);

    $this->get('/logout', [\Map\Http\Controllers\AuthController::class, 'getLogout']);

    $this->get('/api/links', [\Map\Http\Controllers\API\LinkController::class, 'index']);
    $this->get('/api/nodes', [\Map\Http\Controllers\API\NodeController::class, 'index']);
})->add($app->getContainer()->get(\Map\Middleware\Authenticated::class));