<?php

namespace Shoyim\Click\Models;

class Transaction
{
    const PAYMENT_SYSTEM_CLICK = 'click';

    protected array $fillable = [
        'user_id',
        'amount',
        'payment_system',
        'payment_id',
    ];
}