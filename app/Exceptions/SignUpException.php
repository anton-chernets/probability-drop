<?php

namespace App\Exceptions;

use Exception;

class SignUpException extends Exception
{
    public function __construct($message)
    {
        parent::__construct();
        throw new Exception($message);
    }
}