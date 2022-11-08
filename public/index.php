<?php

use app\controllers\AuthentificationController;
use app\controllers\ContactController;
use app\controllers\MainController;
use app\core\Application;
use app\core\ErrorsHandler;
use app\models\User;
use Dotenv\Dotenv;

require dirname(__DIR__) . "/vendor/autoload.php";

ErrorsHandler::SetErrorHandler();

$dotenv = Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();

$config = [
    "db" => [
        "dsn" => $_ENV["DB_DSN"],
        "user" => $_ENV["DB_USER"],
        "password" => $_ENV["DB_PASSWORD"]
    ],
    'userClass' => User::class,
];


$app = new Application(dirname(__DIR__), $config);

$app->router->get('/', [new MainController, "home"]);
$app->router->get('/contact', [new ContactController, "contact"]);
$app->router->post('/contact', [new ContactController, "HandlingContactData"]);

$app->router->get('/login', [new AuthentificationController, "login"]);
$app->router->post('/login', [new AuthentificationController, "loginProccessing"]);
$app->router->get('/register', [new AuthentificationController, "register"]);
$app->router->post('/register', [new AuthentificationController, "registerProccessing"]);

$app->router->get('/logout', [new AuthentificationController, "logout"]);
$app->router->get('/profile', [new AuthentificationController, "profile"]);


$app->run();
