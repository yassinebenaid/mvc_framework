<?php

namespace app\core;

class Validator
{
    public static function isNotEmpty(int|string $field)
    {
        return $field != "" && $field != null;
    }

    public static function isValidEmail(string $data)
    {
        $pattern = "/^([a-zA-Z0-9_-])+@([a-zA-Z0-9_-])+(\.([a-zA-Z0-9]){2,6}){0,4}$/";
        return preg_match($pattern, $data);
    }

    public static function isLessThan(string $data, int $max)
    {
        return strlen($data) <= $max;
    }

    public static function isMoreThan(string $data, int $min)
    {
        return strlen($data) >= $min;
    }

    public static function isMatching(string $data, string $needle)
    {
        return $data === $needle;
    }

    public static function ContainsSpecials(string $data)
    {
        $pattern = "/([^a-z^A-Z^0-9])+/";
        return preg_match($pattern, $data);
    }
}
