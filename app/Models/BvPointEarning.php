<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BvPointEarning extends Model
{
    protected $fillable = [
        "user_id",
        'purchased_package_id',
        'purchaser_id',
        'left_point',
        'right_point',
    ];

    public function purchasedPackage(): BelongsTo
    {
        return $this->belongsTo(PurchasedPackage::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function purchaser(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
