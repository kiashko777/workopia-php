<?php

session_start();

use Framework\Router;

require __DIR__ . '/../vendor/autoload.php';
require '../helpers.php';


// Initialize the router
$router = new Router();

// Load routes
$routes = require basePath('routes.php');

//Get the current URI and method
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Route the request
$router->route($uri);