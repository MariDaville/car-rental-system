<?php

namespace App\Core;

class Router
{
    private array $routes = [];

    /**
     * Register a GET route.
     */
    public function get(string $uri, array $action): void
    {
        $this->register('GET', $uri, $action);
    }

    /**
     * Register a POST route.
     */
    public function post(string $uri, array $action): void
    {
        $this->register('POST', $uri, $action);
    }

    /**
     * Register a route.
     */
    private function register(
        string $method,
        string $uri,
        array $action
    ): void {

        $this->routes[$method][$uri] = $action;
    }

    /**
     * Dispatch the incoming request.
     */
    public function dispatch(): void
    {
        $method = $_SERVER['REQUEST_METHOD'];

        $uri = parse_url(
            $_SERVER['REQUEST_URI'],
            PHP_URL_PATH
        );

        $uri = rtrim($uri, '/') ?: '/';

        $action = $this->routes[$method][$uri] ?? null;

        if ($action === null) {
            http_response_code(404);
            echo '404 - Page Not Found';
            return;
        }

        [$controller, $method] = $action;

        $controllerInstance = new $controller();

        if (!is_callable([$controllerInstance, $method])) {
            throw new \RuntimeException(
                'Invalid controller action.'
            );
        }

        $controllerInstance->$method();
    }
}