<?php

include '../bootstrap.php';

$app = new Map\Application();

include '../routes.php';

$app->run();