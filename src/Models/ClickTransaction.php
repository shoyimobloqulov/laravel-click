<?php

namespace Shoyim\Click\Models;

class ClickTransaction
{
    use HasFactory;

    protected $fillable = [
        'click_trans_id',
        'service_id',
        'click_paydoc_id',
        'merchant_trans_id',
        'amount',
        'action',
        'error',
        'error_note',
        'sign_time',
        'sign_string',
        'status'
    ];

    protected $attributes = [
        'status' => 'pending'
    ];
}