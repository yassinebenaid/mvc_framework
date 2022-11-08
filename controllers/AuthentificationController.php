<?php

namespace app\controllers;

use app\core\Application;
use app\core\Controller;
use app\core\middlewares\AuthMiddleware;
use app\models\Login;
use app\models\User;

class AuthentificationController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->layout = "auth";

        $this->AddMiddleWares(new AuthMiddleware(['profile']));
    }

    public function login()
    {
        $user = new Login();
        return $this->renderView("login", ["model" => $user]);
    }

    public function loginProccessing()
    {
        $user = new Login();
        $user->LoadData($this->request->GetBody());
        if ($user->Validate() && $user->login()) {
            Application::$app->session->SetFlash("success", "Wellcome back , hope our sevices are benifit contact us if any probleb is occurs");
            return "success";
        }
        return $this->response->json($user->errors);
    }

    public function register()
    {
        $user = new User();
        return $this->renderview("register", ["model" => $user]);
    }

    public function registerProccessing()
    {
        $model = new User;
        $model->LoadData($this->request->GetBody());

        if ($model->validate() && $model->register()) {
            Application::$app->session->SetFlash("success", "Wellcome '$model->firstname' , hope our sevices are benifit contact us if any probleb is occurs");
            return "success";
        }

        return $this->response->json($model->errors);
    }

    public function logout()
    {
        Application::$app->logout();
        return $this->response->redirect();
    }

    public function profile()
    {
        return $this->renderView("profile");
    }
}
