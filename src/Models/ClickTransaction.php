<?php
namespace Shoyim\Click\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClickTransaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'click_trans_id',
        'merchant_trans_id',
        'click_paydoc_id',
        'amount',
        'service_id',
        'merchant_prepare_id',
        'merchant_confirm_id',
        'error',
        'error_note',
        'sign_time',
    ];

    public function service()
    {
        return $this->belongsTo(ClickService::class);
    }
}