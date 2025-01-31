<?php

namespace App\Models;

use Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

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
            ->when(!empty(request()->input('purchaser')), static function ($query) {
                $query->where('purchaser_id', request()->input('purchaser'));
            });
    }
}
