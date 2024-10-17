<?php

namespace App\Models;

use App\Models\Scopes\AuthUserScope;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;

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

    protected static function booted(): void
    {
        static::addGlobalScope(AuthUserScope::class);

        static::creating(function (Order $order) {
            $order->user_id = Auth::id();
        });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
