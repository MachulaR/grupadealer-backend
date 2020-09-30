<?php

namespace App\Exception;

class UserNotExistException extends \Exception
{
    protected $message = "One or more users not exist! Check that and try again";
}