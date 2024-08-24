<?php

namespace Statistics\Helpers;

use Exception;
use Illuminate\Support\MessageBag;

class Helpers
{
    static public function getExceptionClass() : string
    {
        $customExceptionClass = config("statistics-config.custom-exception-class");
        return is_subclass_of($customExceptionClass , Exception::class)
               ? $customExceptionClass
               : Exception::class;
    }

}