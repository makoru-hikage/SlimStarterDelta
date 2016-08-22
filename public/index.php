<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

/* Load all libraries installed via Composer */
require '../vendor/autoload.php';

/* Prepares all configuration files */
$config = array();
foreach (glob('../app/config/*.php') as $configFile) {
    require $configFile;
}

$app = new \Slim\App($config);
require '../app/container/container.php';

require '../app/routes/InitialRoute.php';
$app->run();
