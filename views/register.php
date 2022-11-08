<?php

use app\core\widgets\Button;
use app\core\widgets\Form;
use app\core\widgets\Input;

$form = new Form("/register", "post", "Registration");
$form->AddWidget(
    "row",
    new Input("text", "firstname", $model, "col form-group"),
    new Input("text", "lastname", $model, "col form-group")
)
    ->AddWidget(null, new Input("email", "email", $model, "form-group"))
    ->AddWidget(null, new Input("password", "password",  $model, "form-group"))
    ->AddWidget(null, new Input("password", "confirmPassword", $model, "form-group"))
    ->AddWidget(null, new Button("submit", "submit", "btn", "form-group"));
?>

<div class="form">
    <?= $form->render() ?>
</div>