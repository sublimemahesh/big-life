<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BvPointReward extends Model
{
    protected $fillable = [
        "user_id",
        'bv_points',
        'amount',
        'status',
    ];

    protected function getLostAmountAttribute(): float
    {
        return $this->amount - $this->paid;
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
