<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class BvPointReward extends Model
{
    protected $fillable = [
        "user_id",
        "bv_point_earning_id",
        "purchased_package_id",
        "level_user_id",
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

    public function earnings(): morphMany
    {
        return $this->morphMany(Earning::class, 'earnable', 'earnable_type', 'earnable_id');
    }

    public function getPackageInfoJsonAttribute()
    {
        return $this->purchasedPackage->package_info_json;
    }

    public function purchasedPackage(): BelongsTo
    {
        return $this->belongsTo(PurchasedPackage::class, 'purchased_package_id')->withDefault();
    }

    public function package()
    {
        return $this->package_info_json;
    }
}
