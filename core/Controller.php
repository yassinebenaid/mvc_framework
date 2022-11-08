<?php

namespace app\core;

use app\core\middlewares\BaseMiddleware;

class Controller
{
    public Request $request;
    public Response $response;
    public string $layout;
    public string $currentAction = "";

    private array $middlewares = [];

    public function __construct()
    {
        $this->request = Application::$app->request;
        $this->response = Application::$app->response;
    }

    public function renderView(string $page, array $params = [])
    {
        return Application::$app->view->render($page, $params);
    }

    public function AddMiddlewares(BaseMiddleware $middleware)
    {
        $this->middlewares[] = $middleware;
    }

    public function GetMiddlewares()
    {
        return $this->middlewares;
    }
}
