<?php

namespace app\core;

class ErrorsHandler
{
    public static function SetErrorHandler()
    {
        return set_error_handler(["app\core\ErrorsHandler", "ViewCostumError"], E_ALL);
    }

    public static function ViewCostumError($err_no, $err_str, $err_file, $err_line)
    {
        $message = "<div class='error'>Error [$err_no] : $err_str <br>" . "At line : $err_line <br>" . "IN : $err_file <br></div>";
        echo $message;
    }
}
