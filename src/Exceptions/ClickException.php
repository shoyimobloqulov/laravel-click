<?php

namespace Shoyim\Click\Exceptions;

use Exception;

class ClickException extends Exception
{
    public function __construct($message, $code = 0, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    public function report()
    {
        // Here you can log the exception or send it to an external service
    }

    public function render($request)
    {
        return response()->json([
            'error' => $this->getCode(),
            'error_note' => $this->getMessage(),
        ]);
    }
}