<?php

namespace App\Models;

use Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

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

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function scopeFilter(Builder $query): Builder
    {
        return $query->when(!empty(request()->input('date-range')),
            static function ($query) {
                $period = explode(' to ', request()->input('date-range'));
                try {
                    $date1 = Carbon::parse($period[0])->format('Y-m-d H:i:s');
                    $date2 = Carbon::parse($period[1])->format('Y-m-d H:i:s');
                    $query->when($date1 && $date2, fn($q) => $q->where('created_at', '>=', $date1)->where('created_at', '<=', $date2));
                } catch (\Exception $e) {
                    $query->whereDate('created_at', $period[0]);
                } finally {
                    return;
                }
            })
            ->when(!empty(request()->input('status')), static function ($query) {
                $query->where('status', request()->input('status'));
            })
            ->when(!empty(request()->input('purchaser')), static function ($query) {
                $query->where('level_user_id', request()->input('purchaser'));
            });
    }
}
