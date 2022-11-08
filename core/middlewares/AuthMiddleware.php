<?php

namespace app\core\middlewares;

use app\core\Application;
use app\core\exceptions\ForbiddenException;

class AuthMiddleware extends BaseMiddleware
{
    private array $sensitiveActions = [];

    public function __construct(array $sensitive_actions = [])
    {
        $this->sensitiveActions = $sensitive_actions;
    }

    public function execute()
    {
        if (Application::$app->IsGest()) {
            if (empty($this->sensitiveActions) || in_array(Application::$app->controller->currentAction, $this->sensitiveActions)) {
                throw new ForbiddenException();
            }
        }
    }
}
