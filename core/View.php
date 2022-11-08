<?php

namespace app\core;

class View
{
    private string $RootDirectory;
    public string $title = "Home";

    public function __construct(string $root_dir)
    {
        $this->RootDirectory = $root_dir;
    }

    public function render(string $page, array $params = []): string
    {

        $this->title = strtoupper($page);
        $page = $this->GetPage($page, $params);
        $layout = $this->GetLayout();

        return str_replace("{{content}}", $page, $layout);
    }

    private function GetLayout()
    {
        $layout = Application::$app->controller->layout ?? "main";

        ob_start();
        include_once $this->RootDirectory . "/views/layouts/$layout.php";
        return ob_get_clean();
    }

    private function GetPage(string $page, array $params = [])
    {
        ob_start();

        foreach ($params as $key => $value) {
            $$key = $value;
        }

        include_once $this->RootDirectory . "/views/$page.php";

        return ob_get_clean();
    }
}
