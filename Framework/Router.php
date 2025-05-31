<?php

namespace Framework;

use App\controllers\ErrorController;
use Framework\middleware\Authorize;

class Router
{
    protected array $routes = [];

    /**
     *Add a route
     *
     * @param string $method
     * @param string $uri
     * @param string $action
     * @param array $middleware
     * @return void
     */

    public function registerRoute(string $method, string $uri, string $action, $middleware = []): void
    {
        [$controller, $controllerMethod] = explode('@', $action);

        $this->routes[] = [
          'method' => $method,
          'uri' => $uri,
          'controller' => $controller,
          'controllerMethod' => $controllerMethod,
          'middleware' => $middleware
        ];
    }

    /**
     *Add a GET route
     *
     * @param string $uri
     * @param string $controller
     * @param array $middleware
     * @return void
     */
    public function get(string $uri, string $controller, $middleware = []): void
    {
        $this->registerRoute('GET', $uri, $controller, $middleware);
    }

    /**
     *Add a POST route
     *
     * @param string $uri
     * @param string $controller
     * @param array $middleware
     * @return void
     */
    public function post(string $uri, string $controller, array $middleware = []): void
    {
        $this->registerRoute('POST', $uri, $controller, $middleware);
    }

    /**
     *Add a PUT route
     *
     * @param string $uri
     * @param string $controller
     * @param array $middleware
     * @return void
     */
    public function put(string $uri, string $controller, array $middleware = []): void
    {
        $this->registerRoute('PUT', $uri, $controller, $middleware);
    }

    /**
     *Add a DELETE route
     *
     * @param string $uri
     * @param string $controller
     * @param array $middleware
     * @return void
     */
    public
    function delete(string $uri, string $controller, array $middleware = []): void
    {
        $this->registerRoute('DELETE', $uri, $controller, $middleware);
    }

    /**
     *Route a request
     * @param string $uri
     * @param string $method
     * @return void
     */

    public function route(string $uri): void
    {
        $requestMethod = $_SERVER['REQUEST_METHOD'];

        //Check for _method input
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['_method'])) {
            $requestMethod = strtoupper($_POST['_method']);
        }

        foreach ($this->routes as $route) {
            //Split the current URI into segments

            $uriSegments = explode('/', trim($uri, '/'));

            //Split the route URI into segments

            $routeSegments = explode('/', trim($route['uri'], '/'));

            $match = true;

//Check if the number of segments matches

            if (count($uriSegments) === count($routeSegments) && strtoupper($requestMethod) === $route['method']) {
                $params = [];
                $match = true;

                for ($i = 0, $iMax = count($uriSegments); $i < $iMax; $i++) {
                    //If uri's do not match and there is no param
                    if ($uriSegments[$i] !== $routeSegments[$i] && !preg_match('/\{(.+?)}/', $routeSegments[$i], $matches)) {
                        $match = false;
                        break;
                    }
                    //Check for the param and add to $params array
                    if (preg_match('/\{(.+?)}/', $routeSegments[$i], $matches)) {
                        $params[$matches[1]] = $uriSegments[$i];
                    }
                }
                if ($match) {
                    foreach ($route['middleware'] as $middleware) {
                        (new Authorize())->handle($middleware);
                    }
                    //Extract controller and controller method
                    $controller = 'App\\controllers\\' . $route['controller'];
                    $controllerMethod = $route['controllerMethod'];

                    //Instantiate the controller and call the method
                    $controllerInstance = new $controller();
                    $controllerInstance->$controllerMethod($params);
                    return;
                }
            }

        }

        ErrorController::notFound();

    }

}

