<?php
// connect the necessary modules
require('api/v1/bootstrap.php');

// connect router
$router = new Router();

// set the path to the controller folder
$router->setPath(SITE_PATH . 'controllers');

// start the router
$router->start();

// run (if needed) migrations
if (USE_MIGRATION) {
    $migrations = new Migrations();
    $migrations->start();
}