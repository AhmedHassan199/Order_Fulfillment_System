<?php
namespace App\Exceptions;

use Exception;

class ImmutableOrderException extends Exception
{
    protected $message = 'Order cannot be modified in its current state';
}
