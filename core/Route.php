<?php

class Router
{
    protected $routes = [];
    protected $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
        $this->handleCORS(); // Handle CORS headers at the start
    }

    // Add route to the router
    public function addRoute($path, $controllerAction)
    {
        $this->routes[$path] = $controllerAction;
    }

    // Main method to run the router logic
    public function run()
    {
        $requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

        // Check if route exists
        if (array_key_exists($requestUri, $this->routes)) {
            list($controllerName, $actionName) = $this->routes[$requestUri];

            // Ensure the controller exists and is instantiable
            if (class_exists($controllerName)) {
                $controller = new $controllerName($this->pdo);

                // Check if action exists in the controller
                if (method_exists($controller, $actionName)) {
                    $controller->$actionName();
                } else {
                    $this->handleError(405); // Method Not Allowed
                }
            } else {
                $this->handleError(404); // Not Found
            }
        } else {
            $this->handleError(404); // Not Found
        }
    }

    // CORS headers should be set before any routing logic
    private function handleCORS()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
            header("Access-Control-Allow-Origin: *");
            header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
            header("Access-Control-Allow-Headers: Content-Type");
            exit;
        }
    }

    // Handle error responses
    private function handleError($code)
    {
        http_response_code($code);
        switch ($code) {
            case 404:
                require '../app/views/http_request/404.php';
                break;
            case 405:
                require_once '../app/views/http_request/405.php'; // Method Not Allowed
                break;
            default:
                echo 'An error occurred';
                break;
        }
    }
}
