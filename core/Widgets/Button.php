<?php

namespace app\core\widgets;

class Button extends FormWidgets
{
    public function __construct(public string $type, public string $placeholder, public string $class)
    {
    }

    public function render(): string
    {
        return sprintf("<button type='%s' class='%s'>%s</button>", $this->type, $this->class, $this->placeholder);
    }
}
