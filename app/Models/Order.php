<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int id
 * @property int user_id
 * @property string product_name
 * @property float amount
 * @property int status
 * @property Carbon created_at
 * @property Carbon updated_at
 */

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'product_name',
        'amount',
        'status',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
