<?php

namespace App\Traits;

use Carbon;

trait NextPaymentDate
{
    public function getNextPaymentDateAttribute(): string
    {

        // MySQL WEEKDAY: 6=Sunday, 0=Monday, 1=Tuesday, 2=Wednesday, 3=Thursday, 4=Friday, 5=Saturday
        // (0,1,2,6) 9 DAY
        // (5) 10 DAY
        // (3,4) 11 DAY
        
        $today = Carbon::parse(date('Y-m-d') . ' ' . $this->created_at->format('H:i:s'));

        $day = strtolower(Carbon::parse($this->created_at)->format('l'));

        if (in_array($day, ['monday', 'tuesday', 'wednesday', 'sunday'])) {
            $firstPayDate = $this->created_at->addDays(9);
        } elseif ($day === 'saturday') {
            $firstPayDate = $this->created_at->addDays(10);
        } elseif (in_array($day, ['thursday', 'friday'])) {
            $firstPayDate = $this->created_at->addDays(11);
        }

        $nextPayDay = $firstPayDate;

        if ($firstPayDate->isPast()) {
            $nextPayDay = $today;
        }
        if ($firstPayDate->isPast() && Carbon::parse($this->last_earned_at)->isToday()) {
            $nextPayDay = $today->addDay();
        }
        if ($nextPayDay->isSaturday() || $nextPayDay->isSunday()) {
            $nextPayDay = $nextPayDay->nextWeekday();
        }
        //return $nextPayDay->format('Y-m-d h:i A');
        return $nextPayDay->format('Y-m-d') . " 12:00 AM";
    }
}
