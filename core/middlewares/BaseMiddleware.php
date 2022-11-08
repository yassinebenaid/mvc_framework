<?php

namespace app\core\middlewares;

use app\core\Controller;

abstract class BaseMiddleware
{
    abstract public function execute();
}
