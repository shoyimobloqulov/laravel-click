<?php
namespace Shoyim\Click\Exceptions;

use Exception;

class ClickException extends Exception
{
    const ERROR_SIGN_CHECK_FAILED = -1;
    const ERROR_ALREADY_PAID = -4;
    const ERROR_ORDER_NOT_FOUND = -5;
    const ERROR_INVALID_AMOUNT = -6;

    public function __construct($message, $code)
    {
        parent::__construct($message, $code);
    }
}