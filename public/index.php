<?php

use Framework\Router;

require __DIR__ . '/../vendor/autoload.php';
require '../helpers.php';

//require basePath('Framework/Router.php');
//require basePath('Framework/Database.php');

//spl_autoload_register(static function ($class) {
//    $path = basePath('Framework/' . $class . '.php');
//    if (file_exists($path)) {
//        require $path;
//    }
//});


// Initialize the router
$router = new Router();

// Load routes
$routes = require basePath('routes.php');

//Get the current URI and method
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Route the request
$router->route($uri);