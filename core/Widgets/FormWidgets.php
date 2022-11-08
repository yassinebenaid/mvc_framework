<?php

namespace app\core\widgets;

use app\core\Model;

abstract class  FormWidgets
{
    public Model $model;
    public string $attribute;
    public string $type;
    abstract public function render(): string;
}
