<?php

namespace app\core;

class Session
{
    private const FLASH_MESSAGES = "flash";

    public function __construct()
    {
        session_start();
        $this->GenerateFlashesDeletion();
    }

    public function SetFlash(string|int $key, $message)
    {
        $_SESSION[self::FLASH_MESSAGES][$key]["message"] = $message;
        $_SESSION[self::FLASH_MESSAGES][$key]["delete"] = false;
    }

    public function GetFlash(string|int $key)
    {
        return $_SESSION[self::FLASH_MESSAGES][$key]["message"] ?? false;
    }

    protected function GenerateFlashesDeletion()
    {
        if (!isset($_SESSION[self::FLASH_MESSAGES])) return;
        foreach ($_SESSION[self::FLASH_MESSAGES] as &$flash) {
            $flash['delete'] = true;
        }
    }

    public function set(string $key, string|int $data)
    {
        $_SESSION[$key] = $data;
    }

    public function get(string $key)
    {
        return $_SESSION[$key] ?? false;
    }

    public function unset(string $key)
    {
        unset($_SESSION[$key]);
    }

    public function __destruct()
    {
        if (!isset($_SESSION[self::FLASH_MESSAGES])) return;
        foreach ($_SESSION[self::FLASH_MESSAGES] as $key => &$flash) {
            if ($flash["delete"]) {
                unset($_SESSION[self::FLASH_MESSAGES][$key]);
            }
        }
    }
}
