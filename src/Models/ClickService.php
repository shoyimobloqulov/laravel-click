<?php
namespace Shoyim\Click\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClickService extends Model
{
    use HasFactory;

    protected $fillable = [
        'service_id',
        'secret_key',
    ];

    public function transactions()
    {
        return $this->hasMany(ClickTransaction::class);
    }
}