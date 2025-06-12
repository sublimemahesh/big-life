<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MaxedOutBvPoint extends Model
{
    protected $fillable = [
        'user_id',
        'purchased_package_id',
        'left_point',
        'right_point',
        'maxed_out_date',
        'reason'
    ];

    /**
     * Get the user that owns the maxed out BV points.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the purchased package that caused the max out.
     */
    public function purchasedPackage(): BelongsTo
    {
        return $this->belongsTo(PurchasedPackage::class);
    }
}
