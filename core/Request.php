<?php

namespace app\core;

class Request
{
    public function Methode()
    {
        return strtolower($_SERVER["REQUEST_METHOD"]);
    }

    public function Path()
    {
        $url = $_SERVER["REQUEST_URI"] ?? '/';
        $questionMark = strpos($url, "?");

        if ($questionMark)
            $url = substr($url, 0, $questionMark);

        return $url;
    }

    public function isGet(): bool
    {
        return $this->Methode() === "get";
    }

    public function isPost(): bool
    {
        return $this->Methode() === "post";
    }

    public function GetBody(): array
    {
        $body = [];

        switch ($this->Methode()) {
            case 'get':
                foreach ($_GET as $key => $value) {
                    $body[$key] = trim(filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS));
                }
                break;

            case 'post':
                foreach ($_POST as $key => $value) {
                    $body[$key] = trim(filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS));
                }
                break;
        }
        return $body;
    }
}
