<?php
namespace App\Exceptions;

use Exception;

class InvalidTransitionException extends Exception
{
    protected $message = 'Invalid order status transition';
}
