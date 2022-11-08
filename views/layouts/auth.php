<?php

use app\core\Application;

$name = Application::$app->user?->GetUserInfo('firstname', "lastname");

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./style/style.css">
    <title><?= $this->title ?></title>
</head>

<body class="auth">
    <div class="container">
        <header>
            <div class="logo">
                Yass<span class="text-danger">ine</span>
            </div>
            <nav>
                <ul>
                    <li><a href="/">main</a></li>
                    <li><a href="/contact">contact</a></li>
                </ul>
                <div class="profile-controle">
                    <ul>
                        <?php if (Application::$app->IsGest()) : ?>
                            <li><a href="/login">Login</a></li>
                            <li><a href="/register">Register</a></li>
                        <?php else : ?>
                            <li><a href="/logout">Logout</a></li>
                            <li><a href="/profile"><?= $name ?></a></li>
                        <?php endif; ?>
                    </ul>
                </div>
            </nav>
        </header>
        <main>
            {{content}}
        </main>
    </div>
</body>
<script src="./js/FormProccessor.js" type="module"></script>
<script src="./js/index.js" type="module"></script>

</html>