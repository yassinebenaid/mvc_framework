<?php

namespace app\core\widgets;

use app\core\Model;


class Input extends FormWidgets
{

    public function __construct(string $type, string $attribute, Model $model, ?string $container = null, string $class = "")
    {
        $this->type = $type;
        $this->model = $model;
        $this->attribute = $attribute;
        $this->container = $container;
        $this->class = $class;
    }

    public function render(): string
    {
        $input = sprintf(
            "%s 
            <label for='%s'>%s</label>
            <input type='%s' name='%s' %s id='%s' placeholder='%s'>
            %s",
            $this->container ? "<div class='$this->container'>" : "",
            $this->attribute,
            $this->model->labels($this->attribute),
            $this->type,
            $this->attribute,
            $this->class ? "class='$this->class'" : "",
            $this->attribute,
            $this->model->labels($this->attribute),
            $this->container ? "</div>" : ""
        );

        return $input;
    }
}
