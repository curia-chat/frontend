<?php

require __DIR__ . '/vendor/autoload.php';

use Src\Controllers\ECLIViewController;

$config = require __DIR__ . '/settings.conf.php';
$request_uri = $_SERVER['REQUEST_URI'];


////////////////////////////
// ROUTING                //
///////////////////////////


if (preg_match('#^/view/([^/]+)$#', strtok($request_uri, '?'), $matches)) {
    $ecli = $matches[1];
    $searchQuery = isset($_GET['q']) ? $_GET['q'] : null;
    $controller = new ECLIViewController();
    $controller->handle($ecli, $config, $searchQuery);
} else {
    http_response_code(404);
    echo "Page not found";
}
