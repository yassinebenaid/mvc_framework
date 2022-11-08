<?php

namespace app\core;

use app\core\exceptions\NotFoundException;

class Router
{
    protected Request $request;
    protected Response $response;
    private array $routes = [];

    public function __construct(Request $_req, Response $_res)
    {
        $this->request = $_req;
        $this->response = $_res;
    }


    public function get(string $path, callable|array|string $callback)
    {
        $this->routes["get"][$path] = $callback;
    }

    public function post(string $path, callable|array|string $callback)
    {
        $this->routes["post"][$path] = $callback;
    }

    public function resolve()
    {
        $methode = $this->request->Methode();
        $path = $this->request->Path();
        $callback =  $this->routes[$methode][$path] ?? false;

        if ($callback === false) {
            throw new NotFoundException();
        } elseif (is_string($callback)) {
            return Application::$app->view->render($callback);
        } elseif (is_array($callback)) {
            Application::$app->controller = $callback[0];
            $this->RunMiddleware($callback[0], $callback[1]);
        }

        return call_user_func($callback);
    }

    private function RunMiddleware(Controller $controller, string $currentAction)
    {
        if (!$controller) return;
        $controller->currentAction  = $currentAction;

        foreach ($controller->GetMiddlewares() as $middleware) {
            $middleware->execute();
        }
    }
}
