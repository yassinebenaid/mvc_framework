<?php

namespace app\controllers;

use app\core\Application;
use app\core\Controller;

class ContactController extends Controller
{
    public function __construct()
    {
        $this->layout = "main";
    }

    public function contact()
    {
        return $this->renderView("contact");
    }

    public function HandlingContactData()
    {
        $body = Application::$app->request->GetBody();
        return json_encode($body);
    }
}
