<?php

namespace app\controllers;


use app\core\Controller;

class MainController extends Controller
{
    public function __construct()
    {
        $this->layout = "main";
    }

    public function home()
    {
        return $this->renderView("home");
    }
}
