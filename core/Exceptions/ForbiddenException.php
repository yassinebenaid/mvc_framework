<?php

namespace app\core\exceptions;

class ForbiddenException extends \Exception
{
    public function __construct()
    {
        $this->code = 403;
        $this->message = "This page is sensitive , right now you can't access it , you need to login then retry again";
    }
}
