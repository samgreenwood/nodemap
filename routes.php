<?php


$app->get('/', [\Map\Http\Controllers\MapController::class, 'index']);
$app->get('/api/links', [\Map\Http\Controllers\API\LinkController::class, 'index']);
$app->get('/api/nodes', [\Map\Http\Controllers\API\NodeController::class, 'index']);