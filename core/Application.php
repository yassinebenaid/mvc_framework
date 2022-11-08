<?php

namespace app\core;

use app\core\database\DatabaseHandler;
use app\core\database\DBModel;
use Attribute;

class Application
{
    public  static self $app;
    public Router $router;
    public Request $request;
    public View $view;
    public Response $response;
    public Session $session;
    public Controller $controller;
    public static $ROOT_DIR;
    public readonly DatabaseHandler $db;
    public  string $userClass;
    public  ?DBModel $user = null;

    public function __construct(string $root_dir, array $config)
    {
        $this->userClass = $config['userClass'];
        self::$ROOT_DIR = $root_dir;
        self::$app = $this;
        $this->request = new Request();
        $this->response = new Response();
        $this->session = new Session();
        $this->router = new Router($this->request, $this->response);
        $this->view = new View(self::$ROOT_DIR);
        $this->db = new DatabaseHandler($config["db"]);

        $this->SetUserInfo();
    }

    public function SetUserInfo()
    {
        $primary_key = $this->session->get('user');
        if ($primary_key) {
            $user = $this->userClass::Find("", $primary_key);
            $this->user = $user;
        }
    }

    public function login(DBModel $user)
    {
        $this->user = $user;
        $primary_key = $user->primaryKey();
        $primary_value = $user->{$primary_key};
        $this->session->set("user", $primary_value);
        return true;
    }



    public function logout()
    {
        $this->user = null;
        $this->session->unset('user');
    }

    public function IsGest()
    {
        return $this->user === null;
    }

    public function run()
    {
        try {
            echo $this->router->resolve();
        } catch (\Exception $e) {
            echo Application::$app->response->RenderError($e->getCode(), $e->getMessage());
        }
    }
}
