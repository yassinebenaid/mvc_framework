<?php

namespace app\core\widgets;

final class Form
{

    private array $FormWidgets = [];

    public function __construct(
        private string $action,
        private string $method,
        private string $title = "",
        private string $class = "",
        private string $id = ""
    ) {
    }

    public function AddWidget(?string $container = null, FormWidgets ...$widgets)
    {
        $widgets = join(" ", array_map(fn ($el) => $el->render(), $widgets));

        $this->FormWidgets[] = (!is_null($container)) ? $this->addContainer($container, $widgets) : $widgets;
        return $this;
    }

    private function addContainer(string $class, string $child)
    {
        return sprintf("<div class='%s' >%s </div>", $class, $child);
    }

    public function render(): string
    {
        $inputs = join(PHP_EOL, $this->FormWidgets);
        return sprintf(
            "<form action='%s' method='%s' class='%s' id='%s'><h1>%s</h1> %s </form>",
            $this->action,
            $this->method,
            $this->class,
            $this->id,
            $this->title,
            $inputs
        );
    }
}
