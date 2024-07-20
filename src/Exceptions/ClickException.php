<?php

namespace Shoyim\Click\Exceptions;

use Exception;

class ClickException extends Exception{
    const ERROR_INTERNAL_SYSTEM = -32400;
    const ERROR_INSUFFICIENT_PRIVILEGE = -32504;
    const ERROR_INVALID_JSON_RPC_OBJECT = -32600;
    const ERROR_METHOD_NOT_FOUND = -32601;
    const ERROR_INVALID_AMOUNT = -31001;
    const ERROR_TRANSACTION_NOT_FOUND = -31003;
    const ERROR_INVALID_ACCOUNT = -31050;
    const ERROR_COULD_NOT_CANCEL = -31007;
    const ERROR_COULD_NOT_PERFORM = -31008;
    public $error;

    /**
     * ClickException contructor
     */

    public function __construct($error_note, $error_code)
    {
        $this->error_note = $error_note;
        $this->error_code = $error_code;

        $this->error = ['error_code' => $this->error_code];

        if ($this->error_note) {
            $this->error['error_note'] = $this->error_note;
        }
    }

    /**
     * @return array array-like
     */
    public function error()
    {
        return $this->error;
    }
}