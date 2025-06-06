<?php

//Thi is the entry point of the application -  initialize the autoloader, session and helpers,
// then load the router, routes and the current URI and method.

require __DIR__ . '/../vendor/autoload.php';

use Framework\Router;

use Framework\Session;

Session::start();

require '../helpers.php';


// Initialize the router
$router = new Router();

// Load routes
$routes = require basePath('routes.php');

//Get the current URI and method
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Route the request
$router->route($uri);