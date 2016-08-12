<?php

include '../bootstrap.php';

$app = new \Slim\App($container);

include '../routes.php';

$app->run();