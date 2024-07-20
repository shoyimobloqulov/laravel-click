<?php

namespace Shoyim\Click\Models;

use Illuminate\Database\Eloquent\Model;

class ClickTransaction extends Model
{
    const ACTION_PREPARE = 0;
    const ACTION_COMPLETE = 1;

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

    protected $fillable = [
        'click_trans_id',
        'service_id',
        'click_paydoc_id',
        'merchant_trans_id',
        'amount',
        'sign_time',
        'situation',
        'status',
    ];
}