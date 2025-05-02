<?php

require '../helpers.php';
require basePath('Router.php');
require basePath('Database.php');


// Initialize the router
$router = new Router();

// Load routes
$routes = require basePath('routes.php');

//Get the current URI and method
$uri = $_SERVER['REQUEST_URI'];
$method = $_SERVER['REQUEST_METHOD'];

// Route the request
$router->route($uri, $method);