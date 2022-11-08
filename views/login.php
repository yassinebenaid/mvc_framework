<?php

use app\core\widgets\Button;
use app\core\widgets\Form;
use app\core\widgets\Input;

$form = new Form("/login", "post", "Logging");
$form->AddWidget(null, new Input("email", "email", $model, "form-group"));
$form->AddWidget(null, new Input("password", "password", $model, "form-group"));
$form->AddWidget(null, new Button("submit", "Confirm", "btn"));
?>
<div class="form">
    <?= $form->render() ?>
</div>