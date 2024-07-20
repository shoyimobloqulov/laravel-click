<?php

namespace Shoyim\Click\Exceptions;

use Exception;

class ClickException extends Exception
{
    public mixed $error;

    const SUCCESS = 0;
    const SIGN_CHECK_FAILED = -1;
    const INCORRECT_PARAMETER_AMOUNT = -2;
    const ACTION_NOT_FOUND = -3;
    const ALREADY_PAID = -4;
    const USER_DOES_NOT_EXISTS = -5;
    const TRANSACTION_DOES_NOT_EXISTS = -6;
    const FAILED_TO_UPDATE_USER = -7;
    const ERROR_IN_REQUEST_CLICK = -8;
    const TRANSACTION_CANCELLED = -9;
    const IP_NOT_ALLOWED = -10;
    const ERROR_INVALID_JSON_RPC_OBJECT = 1;
    const ERROR_COULD_NOT_PERFORM = 2;
    public function __construct(mixed $error)
    {
        $this->error = [
            'error' => $error,
            'error_note' => $this->getErrorMessage($error)
        ];
        parent::__construct();
    }

    public static function getErrorMessage(int $error): string
    {
        return match($error)
        {
            self::SUCCESS => 'Success',
            self::SIGN_CHECK_FAILED => 'SIGN CHECK FAILED!',
            self::INCORRECT_PARAMETER_AMOUNT => 'Incorrect parameter amount',
            self::ACTION_NOT_FOUND => 'Action not found',
            self::ALREADY_PAID => 'Already paid',
            self::USER_DOES_NOT_EXISTS => 'User does not exists',
            self::TRANSACTION_DOES_NOT_EXISTS => 'Transaction does not exists',
            self::FAILED_TO_UPDATE_USER => 'Failed to update user',
            self::ERROR_IN_REQUEST_CLICK => 'Error in request click',
            self::TRANSACTION_CANCELLED => 'Transaction cancelled',
            self::IP_NOT_ALLOWED => 'IP not allowed',
        };
    }
}