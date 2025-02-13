<?php

namespace App\Jobs;

use App\Models\Earning;
use App\Models\PurchasedPackage;
use App\Models\Strategy;
use App\Models\Wallet;
use Carbon\Carbon;
use DB;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\Middleware\WithoutOverlapping;
use Illuminate\Queue\SerializesModels;
use Log;

class GenerateUserDailyEarning implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private PurchasedPackage $purchase;
    private Carbon|null $execution_time;
    private string $date;

    public function __construct(PurchasedPackage $purchase, string $date, $execution_time = null)
    {
        $this->purchase = $purchase;
        $this->date = $date;
        $this->execution_time = $execution_time ?? now();
    }

    public function middleware()
    {
        return [(new WithoutOverlapping($this->purchase->id))->releaseAfter(60)];
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->calculateProfit($this->purchase);
    }

    private function calculateProfit(PurchasedPackage $purchase): void
    {

        try {
            DB::transaction(function () use ($purchase) {
                $date = $this->date;

                $daily_max_out_limit = $purchase->daily_max_out_limit ?? $purchase->packageRef->daily_max_out_limit;

                $today_earnings_for_active_package = Earning::where('user_id', $purchase->user_id)
                    ->where('purchased_package_id', $purchase->id)
                    ->whereDate('created_at', $date)
                    ->whereIn('status', ['RECEIVED', 'HOLD'])
                    ->sum('amount');

                Log::channel('max-out-log')->info(
                    "Package {$purchase->id} | " .
                    "Max out limit: {$daily_max_out_limit}. | " .
                    "Today(" . $date . ") Earnings: {$today_earnings_for_active_package}. | " .
                    "Package Ref Max out Limit: {$purchase->packageRef->daily_max_out_limit}. | " .
                    "Purchased Date: {$purchase->created_at} | " .
                    "User: {$purchase->user->username} - {$purchase->user_id}");


                if ($today_earnings_for_active_package >= $daily_max_out_limit) {
                    Log::channel('max-out-log')->warning("No earnings recorded because of max out limit {$daily_max_out_limit} exceeded today(" . $date . ") max out limit {$today_earnings_for_active_package}. | " .
                        "Package {$purchase->id} | " .
                        "User: {$purchase->user->username} - {$purchase->user_id} ");

                    return;
                }

                $earned = $purchase->earnings()->whereDate('created_at', $date)->where('type', 'PACKAGE')->doesntExist();
                // $earned = Earning::where('purchased_package_id', $purchase->id)->whereDate('created_at', $date)->doesntExist();
                if ($earned) {

                    $purchase->loadSum(['earnings' => fn($q) => $q->where('type', 'PACKAGE')], 'amount');

                    $payable_percentages = Strategy::where('name', 'payable_percentages')->firstOr(fn() => new Strategy(['value' => '{"direct":0.332,"indirect":0.332,"package":1}']));
                    $payable_percentages = json_decode($payable_percentages->value, false, 512, JSON_THROW_ON_ERROR);
                    $payable_percentage = $payable_percentages->package ?? $purchase->payable_percentage;

//                    $already_earned_percentage = $purchase->earned_profit;
//                    $total_already_earned_income = ($purchase->invested_amount / 100) * $already_earned_percentage;
                    $total_already_earned_income = $purchase->earnings_sum_amount;
                    $total_allowed_income = ($purchase->invested_amount / 100) * $purchase->investment_profit;


                    $remaining_income = $total_allowed_income - $total_already_earned_income;

                    $earned_amount = $purchase->invested_amount * ((float)$payable_percentage / 100);


                    if ($total_allowed_income < ($total_already_earned_income + $earned_amount)) {
                        $earned_amount = $total_allowed_income - $total_already_earned_income;
                        $purchase->update(['status' => 'EXPIRED']);
                        Log::channel('daily')->info(
                            "Package {$purchase->id} | " .
                            "COMPLETED {$total_already_earned_income}. | " .
                            "Purchased Date: {$purchase->created_at} | " .
                            "User: {$purchase->user->username} - {$purchase->user_id}");
                    }

                    if ($purchase->investment_profit <= $purchase->package_earned_profit) {
                        $earned_amount = 0;
                        $purchase->update(['status' => 'EXPIRED']);
                        Log::channel('daily')->warning(
                            "Package {$purchase->id} | " .
                            "PACKAGE FILLED | investment_profit <= earned_profit | {$purchase->investment_profit} <= {$purchase->earned_profit} | " .
                            "COMPLETED {$total_already_earned_income}. | " .
                            "Purchased Date: {$purchase->created_at} | " .
                            "User: {$purchase->user->username} - {$purchase->user_id}");
                    }

                    if ($earned_amount > 0) {
                        $purchase->earnings()->save(Earning::forceCreate([
                            'user_id' => $purchase->user_id,
                            'purchased_package_id' => $purchase->id,
                            'amount' => $earned_amount,
                            'payed_percentage' => $payable_percentage,
                            'type' => 'PACKAGE',
                            'status' => 'RECEIVED',
                            'created_at' => $this->execution_time,
                            'updated_at' => $this->execution_time
                        ]));

                        $package_earned_income = $total_already_earned_income + $earned_amount;
                        $package_earned_income_percentage = ($package_earned_income / $purchase->total_package_profit) * 100;
                        $package_earned_income_percentage_from_profit_percentage = ($package_earned_income_percentage / 100) * $purchase->investment_profit;

                        $total_already_earned_income = $purchase->total_earned_profit + $earned_amount;
                        $total_already_earned_income_percentage = ($total_already_earned_income / $purchase->total_profit) * 100;
                        $total_already_earned_income_percentage_from_profit_percentage = ($total_already_earned_income_percentage / 100) * $purchase->total_profit_percentage;

                        $purchase->update([
                            'package_earned_profit' => $package_earned_income_percentage_from_profit_percentage,
                            'earned_profit' => $total_already_earned_income_percentage_from_profit_percentage,
                            'last_earned_at' => $this->execution_time
                        ]);

                        $wallet = Wallet::firstOrCreate(
                            ['user_id' => $purchase->user_id],
                            ['balance' => 0]
                        );

                        $wallet->increment('balance', $earned_amount);

                    }
                    //Wallet::updateOrCreate(['user_id' => $purchase->user_id]);
                    Log::channel('daily')->notice("Purchased Package Earning saved (" . $date . "). | Package: " . $purchase->id . " Purchased Date: " . $purchase->created_at . " | User: " . $purchase->user->username . "-" . $purchase->user_id);
                } else {
                    Log::channel('daily')->warning("Purchased Package Already earned! (" . $date . "). | Package: " . $purchase->id . " Purchased Date: " . $purchase->created_at . " | User: " . $purchase->user->username . "-" . $purchase->user_id);
                }
            });
        } catch (\Throwable $e) {
            Log::channel('daily')->error($e->getMessage() . " | Package: " . $purchase->id . " Purchased Date: " . $purchase->created_at . " | User: " . $purchase->user->username . "-" . $purchase->user_id);
        }

    }
}
