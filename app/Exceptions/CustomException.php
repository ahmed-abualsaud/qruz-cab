<?php

namespace App\Exceptions;

use Exception;

class CustomException extends Exception
{
    /**
    * CustomException constructor.
    * 
    * @param  string  $message
    * @param  string  $reason
    * @return void
    */
    public function __construct(string $message)
    {
        parent::__construct($message);
    }
}