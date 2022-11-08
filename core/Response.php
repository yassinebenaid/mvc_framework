<?php

namespace app\core;

class Response
{
    public function RenderError(int $code, string $message)
    {
        $this->SetStatusCode($code);
        return Application::$app->view->render("__Error", ["code" => $code, "message" => $message]);
    }

    public function SetStatusCode(int $code)
    {
        http_response_code($code);
    }

    public function json(mixed $data)
    {
        return json_encode($data);
    }

    public function redirect(string $url = "/")
    {
        header("Location: $url");
    }
}
