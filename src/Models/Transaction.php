<?php
namespace Shoyim\Click\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    const PAYMENT_SYSTEM_CLICK = 'click';

    protected $fillable = [
        'user_id',
        'amount',
        'payment_system',
        'payment_id',
    ];
}