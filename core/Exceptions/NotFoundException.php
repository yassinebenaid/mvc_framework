<?php

namespace app\core\exceptions;

class NotFoundException  extends \Exception
{
    public function __construct()
    {
        $this->code = 404;
        $this->message = "the server could't find this page ,this probably happend because of the url which may be broken or the page itself was deleted , check the url or call <a href='/'>support</a>";
    }
}
