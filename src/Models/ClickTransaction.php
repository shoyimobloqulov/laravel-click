<?php

namespace Shoyim\Click\Models;

use Illuminate\Database\Eloquent\Model;

class ClickTransaction extends Model
{
    const ERROR_IN_REQUEST_CLICK = 'Error in request click';
    const USER_DOES_NOT_EXISTS = 'User does not exist';
    const TRANSACTION_DOES_NOT_EXISTS = 'Transaction does not exist';
    const ALREADY_PAID = 'Already paid';
    const SUCCESS = 0;
    const ACTION_PREPARE = 0;
    const ACTION_COMPLETE = 1;

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