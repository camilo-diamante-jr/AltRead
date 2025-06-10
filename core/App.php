<?php

require_once 'View.php';

class App
{
    protected $pdo;
    protected $router;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
        $this->router = new Router($pdo);
    }

    public function run()
    {
        require_once '../routes/auth.php';
        require_once '../routes/web.php';



        $userRole = $_SESSION['user_type'] ?? null;

        switch ($userRole) {
            case 'Admin':
                $this->loadRoutes('admin', 'AdminMainController', '/admin');
                break;
            case 'Teacher':
                $this->loadRoutes('teacher', 'TeacherController', '/teacher');
                break;
            case 'Learner':
                $this->loadRoutes('learner', 'StudentMainController', '/student');
                break;
        }

        require_once '../routes/api.php';

        $this->router->run();
    }

    protected function loadRoutes(string $file, string $controller, string $prefix)
    {
        $routes = require "../routes/{$file}.php";
        foreach ($routes as $route) {
            $this->router->addRoute(
                $prefix . $route['url'],
                [$controller, $route['method']]
            );
        }
    }

    public function renderView($view, $data = [])
    {
        View::render($view, $data);
    }
}
