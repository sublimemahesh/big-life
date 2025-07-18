<?php

namespace App\Jobs;

use App\Events\UserReachedDailyMaxOut;
use App\Models\AdminWallet;
use App\Models\Commission;
use App\Models\Earning;
use App\Models\PurchasedPackage;
use App\Models\Strategy;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\Middleware\WithoutOverlapping;
use Illuminate\Queue\SerializesModels;
use Log;
use Throwable;

class SaleLevelCommissionJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private PurchasedPackage $package;

    private User $purchasedUser;

    private mixed $strategies;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(User $purchasedUser, PurchasedPackage $package)
    {
        $this->purchasedUser = $purchasedUser;
        $this->package = $package;
        $this->strategies = Strategy::whereIn('name', [
            'rank_gift',
            'rank_bonus',
            'commissions',
            'level_commission_requirement',
            'commission_level_count',
            'old_users_commission_divide',
            'max_withdraw_limit'
        ])->get();
    }

    public function middleware()
    {
        return [(new WithoutOverlapping($this->package->id))->releaseAfter(60)];
    }

    /**
     * Execute the job.
     *
     * @return void
     * @throws Throwable
     */
    public function handle()
    {

        Log::channel('daily')->info(
            "SaleLevelCommissionJob Started | PURCHASE PACKAGE: {$this->package->id} | " .
            "USER : {$this->purchasedUser->username} - {$this->purchasedUser->id}"
        );


        \DB::transaction(function () {
            $purchasedUser = $this->purchasedUser;
            $package = $this->package;
            $strategies = $this->strategies;

            if ($package->invested_amount <= 0) {
                $package->update(['commission_issued_at' => now()]);
                return true;
            }

            $level_commission_requirement = $strategies->where('name', 'level_commission_requirement')->first(null, fn() => new Strategy(['value' => 1]));

            $commissions = $strategies->where('name', 'commissions')->first(null, fn() => new Strategy(['value' => '{"1":"8","2":"2","3":"1"}']));
            $commissions = json_decode($commissions->value, true, 512, JSON_THROW_ON_ERROR);


            $rank_gift_percentage = $strategies->where('name', 'rank_gift')->first(null, fn() => new Strategy(['value' => '5']));
            $rank_bonus_percentage = $strategies->where('name', 'rank_bonus')->first(null, fn() => new Strategy(['value' => '10']));

            $total_commission_and_bonus_percentage = $rank_gift_percentage->value + $rank_bonus_percentage->value + array_sum($commissions);
            $total_package_left_income_percentage = 100 - $total_commission_and_bonus_percentage;

            $total_package_left_income = ($package->invested_amount * $total_commission_and_bonus_percentage) / 100;
            $allocated_for_gift = ($package->invested_amount * $rank_gift_percentage->value) / 100;
            $rank_bonus_percentage = ($package->invested_amount * $rank_bonus_percentage->value) / 100;
            $total_allocated_level_commissions = ($package->invested_amount * array_sum($commissions)) / 100;
            $total_profit_for_company_from_package = ($package->invested_amount * $total_package_left_income_percentage) / 100;

            $less_level_commissions = $total_allocated_level_commissions;
            $commission_start_at = 1;
            if ($purchasedUser->super_parent_id !== null) {
                $commission_level_strategy = $strategies->where('name', 'commission_level_count')->first(null, fn() => new Strategy(['value' => 4]));
                $old_users_commission_divide = $strategies->where('name', 'old_users_commission_divide')->first(null, fn() => new Strategy(['value' => 2]));
                $commission_level = (int)$commission_level_strategy->value;

                $purchasePackageCount = $purchasedUser->purchasedPackages()->count();
                $is_new_customer_first_purchase = $purchasePackageCount <= 1;

                $commission_level_user = $purchasedUser->sponsor instanceof User ? $purchasedUser->sponsor : User::find($purchasedUser->super_parent_id);
                for ($i = $commission_start_at; $i <= $commission_level; $i++) {

                    $commission_percentage = $commissions[$i];
                    Log::channel('daily')->debug("Purchased Package Count: $purchasePackageCount | Commission Level: $i | Commission Percentage: $commission_percentage");
                    if (!$is_new_customer_first_purchase) {
                        $commission_percentage /= ($old_users_commission_divide->value ?? 2);
                        Log::channel('daily')->debug("Not a New Customer Fresh Purchase: Purchased Package Count: $purchasePackageCount | Commission Level: $i | Commission Percentage: $commission_percentage");
                    }

                    $commission_amount = ($package->invested_amount * $commission_percentage) / 100;

                    $direct_sale_count = $commission_level_user->children()->count();
                    $is_level_commission_requirement_satisfied = $direct_sale_count >= ($level_commission_requirement->value ?? 1);

                    $isQualified = $commission_level_user->is_active && $is_level_commission_requirement_satisfied;
                    $commission_amount_left = $isQualified ? 0 : $commission_amount;

                    Log::channel('daily')->{$isQualified ? 'info' : 'warning'}("COMMISSION ELIGIBILITY | PURCHASE PACKAGE: {$package->id} | COMMISSION AMOUNT: {$commission_amount} ", [
                        'commission_level_user' => $commission_level_user->id,
                        'direct_sale_count' => $direct_sale_count,
                        'level_commission_requirement' => $level_commission_requirement->value ?? 5,
                        'is_level_commission_requirement_satisfied' => $is_level_commission_requirement_satisfied,
                        'commission_level_user is_active' => $commission_level_user->is_active,
                        'isQualified' => $isQualified,
                    ]);

                    $commission = Commission::forceCreate([
                        'user_id' => $commission_level_user->id,
                        'level_user_id' => $purchasedUser->id,
                        'commission_level' => $i,
                        'purchased_package_id' => $package->id,
                        'amount' => $commission_amount,
                        'paid' => 0,
                        'type' => $i === 1 ? 'DIRECT' : 'INDIRECT',
                        'status' => $isQualified ? 'QUALIFIED' : 'DISQUALIFIED'
                    ]);

                    $less_level_commissions -= $commission->amount;


                    if ($isQualified) {

                        $daily_max_out_limit = $commission_level_user->effective_daily_max_out_limit;  // get the highest daily max out limit from the user active packages'
                        $commissionLevelUserActivePackages = $commission_level_user->activePackages;

                        foreach ($commissionLevelUserActivePackages as $activePackage) {
                            // Refresh today's total earnings for each iteration to get the most up-to-date value
                            $today_total_earnings = Earning::where('user_id', $commission->user_id)
                                //->where('purchased_package_id', $activePackage->id)
                                ->whereDate('created_at', date('Y-m-d'))
                                ->whereIn('status', ['RECEIVED', 'HOLD'])
                                ->whereNotIn('type', ['RANK_BONUS', 'RANK_GIFT', 'P2P', 'STAKING']) // 'PACKAGE','DIRECT','INDIRECT','BV','RANK_BONUS','RANK_GIFT','P2P','STAKING'
                                ->sum('amount');

                            // $daily_max_out_limit = $activePackage->daily_max_out_limit ?? $activePackage->packageRef->daily_max_out_limit;

                            Log::channel('max-out-log')->info(
                                "Package {$activePackage->id} | " .
                                "Max out limit: {$daily_max_out_limit}. | " .
                                "Today(" . date('Y-m-d') . ") Earnings: {$today_total_earnings}. | " .
                                "Package Ref Max out Limit: {$activePackage->packageRef->daily_max_out_limit}. | " .
                                "Purchased Date: {$activePackage->created_at} | " .
                                "User: {$activePackage->user->username} - {$activePackage->user_id}");


                            if ($today_total_earnings >= $daily_max_out_limit) {
                                Log::channel('max-out-log')->warning("No Commission earnings recorded because of max out limit {$daily_max_out_limit} exceeded today(" . date('Y-m-d') . ") max out limit {$today_total_earnings}. | " .
                                    "Package {$activePackage->id} | " .
                                    "User: {$activePackage->user->username} - {$activePackage->user_id} ");

                                event(new UserReachedDailyMaxOut($commission_level_user, $activePackage, "Level Commissions: Daily max limit of {$daily_max_out_limit} exceeded"));

                                Log::channel('max-out-log')->warning("BREAKING THE LOOP");
                                $commission_amount_left = $commission_amount;
                                $commission_amount = 0;
                                break;
                            }

                            $already_earned_percentage = $activePackage->earned_profit;

                            $total_already_earned_income = ($activePackage->invested_amount / 100) * $already_earned_percentage;
                            $total_allowed_income = ($activePackage->invested_amount / 100) * $activePackage->total_profit_percentage;

                            // TODO: BUG $total_allowed_income is not accurate, use commission amount instead and fix
                            $remaining_income = $total_allowed_income - $total_already_earned_income;
                            if ($commission_amount > $remaining_income) {
                                $activePackage->update(['status' => 'EXPIRED']);
                                Log::channel('daily')->info(
                                    "Package {$activePackage->id} | " .
                                    "COMPLETED {$total_already_earned_income}. | " .
                                    "SALES LEVEL COMMISSION TOTAL_ALLOWED_INCOME: {$total_allowed_income}. | " .
                                    "Purchased Date: {$activePackage->created_at} | " .
                                    "User: {$activePackage->user->username} - {$activePackage->user_id}");
//                                $can_paid_commission_amount = $total_allowed_income - $total_already_earned_income;
                                $can_paid_commission_amount = $remaining_income;
                                if ($can_paid_commission_amount <= 0) {
                                    continue;
                                }
                                $commission_amount_left = $commission_amount - $can_paid_commission_amount;
                                $commission_amount = $can_paid_commission_amount;
                            } else {
                                $commission_amount_left = 0;
                            }

                            $today_remaining_income = $daily_max_out_limit - $today_total_earnings;
                            // Zero out BV Points
                            if ($commission_amount >= $today_remaining_income) {
                                event(new UserReachedDailyMaxOut($commission_level_user, $activePackage, "Level Commissions: Daily max limit of {$daily_max_out_limit} exceeded"));
                            }
                            if ($commission_amount > $today_remaining_income) {
                                $can_today_paid_commission_amount = $today_remaining_income;

                                Log::channel('max-out-log')->info("Package {$activePackage->id} | LOGIC: $commission_amount > $today_remaining_income |" .
                                    "CAN_TODAY_PAID_COMMISSION_AMOUNT: $can_today_paid_commission_amount | User: {$activePackage->user->username} - {$activePackage->user_id}");

                                Log::channel('max-out-log')->debug("Package {$activePackage->id} | COMMISSION_AMOUNT: $commission_amount | COMMISSION_AMOUNT_LEFT: $commission_amount_left");

                                if ($can_today_paid_commission_amount <= 0) {
                                    Log::channel('max-out-log')->warning("BREAKING THE LOOP: Package {$activePackage->id} | CAN_TODAY_PAID_COMMISSION_AMOUNT: <= 0");
                                    break;
                                }

                                $commission_amount_left += ($commission_amount - $can_today_paid_commission_amount);
                                $commission_amount = $can_today_paid_commission_amount;

                                Log::channel('max-out-log')->debug("Package {$activePackage->id} | COMMISSION_AMOUNT: $commission_amount | COMMISSION_AMOUNT_LEFT: $commission_amount_left");
                            }

                            $commission->earnings()->save(Earning::forceCreate([
                                'user_id' => $commission->user_id,
                                'level_user_id' => $purchasedUser->id,
                                'income_level' => $i,
                                'purchased_package_id' => $activePackage->id,
                                'amount' => $commission_amount,
                                'payed_percentage' => $commission_percentage,
                                'type' => $commission->type,
                                'status' => 'RECEIVED',
                            ]));
                            // TODO: Strange error on update object of class stdclass could not be converted to string
//                            $commission->update(['last_earned_at' => \Carbon::now()->format('Y-m-d H:i:s')]);
                            Commission::find($commission->id)->update(['last_earned_at' => \Carbon::now()->format('Y-m-d H:i:s')]);
                            $commission->increment('paid', $commission_amount);

                            $total_already_earned_income = $activePackage->total_earned_profit + $commission_amount;
                            $total_already_earned_income_percentage = ($total_already_earned_income / $activePackage->total_profit) * 100;
                            $total_already_earned_income_percentage_from_profit_percentage = ($total_already_earned_income_percentage / 100) * $activePackage->total_profit_percentage;

                            $activePackage->update(['earned_profit' => $total_already_earned_income_percentage_from_profit_percentage]);

                            if ($activePackage->total_profit <= ($total_already_earned_income)) {
                                $activePackage->update(['status' => 'EXPIRED']);
                                Log::channel('daily')->info(
                                    "Package {$activePackage->id} | " .
                                    "COMPLETED {$total_already_earned_income}. | " .
                                    "SALES LEVEL COMMISSION TOTAL_PROFIT: {$activePackage->total_profit}. | " .
                                    "Purchased Date: {$activePackage->created_at} | " .
                                    "User: {$activePackage->user->username} - {$activePackage->user_id}");
                            }

                            $wallet = Wallet::firstOrCreate(
                                ['user_id' => $commission->user_id],
                                ['balance' => 0]
                            );
                            $wallet->increment('balance', $commission_amount);

                            if ($commission_amount_left <= 0) {
                                break;
                            }
                            $commission_amount = $commission_amount_left;
                        }

                    }

                    if (!$isQualified || $commission_amount_left > 0) {
                        $commission->refresh();
                        if ($commission_amount_left > 0 && $commission_amount_left !== $commission->amount) {
                            Commission::forceCreate([
                                'parent_id' => $commission->id,
                                'level_user_id' => $purchasedUser->id,
                                'commission_level' => $i,
                                'user_id' => $commission_level_user->id,
                                'purchased_package_id' => $package->id,
                                'amount' => $commission_amount_left,
                                'paid' => 0,
                                'type' => $i === 1 ? 'DIRECT' : 'INDIRECT',
                                'status' => 'DISQUALIFIED'
                            ]);
                        }


                        $commission->adminEarnings()->create([
                            'user_id' => $commission->user_id,
                            'type' => 'DISQUALIFIED_COMMISSION',
                            'amount' => $commission_amount_left,
                        ]);

                        $admin_wallet = AdminWallet::firstOrCreate(
                            ['wallet_type' => 'DISQUALIFIED_COMMISSION'],
                            ['balance' => 0]
                        );

                        $admin_wallet->increment('balance', $commission_amount_left);
                    }

                    if ($commission->paid <= 0) {
                        $commission->update(['status' => 'DISQUALIFIED']);
                    }

                    if ($commission_level_user->super_parent_id === null) {
                        Log::channel('daily')->warning(
                            "NO INDIRECT PARENT USER FOUND | PURCHASE PACKAGE: {$package->id} | " .
                            "COMMISSION LEVEL: {$i} | " .
                            "USER : {$purchasedUser->username} - {$purchasedUser->id} | " .
                            "LEVEL USER : {$commission_level_user->username} - {$commission_level_user->id}");
                        break;
                    }
                    $commission_level_user = $commission_level_user->sponsor;
                }
            } else {
                Log::channel('daily')->warning("NO DIRECT PARENT USER FOUND | PURCHASE PACKAGE: {$package->id} | USER: {$purchasedUser->username} - {$purchasedUser->id}");
            }


            $log_context = compact(
                'total_commission_and_bonus_percentage',
                'total_package_left_income_percentage',
                'total_package_left_income',
                'allocated_for_gift',
                'rank_bonus_percentage',
                'total_allocated_level_commissions',
                'less_level_commissions',
                'total_profit_for_company_from_package',
            );

            Log::channel('daily')->info("PURCHASE PACKAGE: {$package->id} | INVESTED AMOUNT:{$package->invested_amount}", $log_context);

            if ($less_level_commissions > 0 || $total_profit_for_company_from_package > 0) {
                $package->adminEarnings()->create([
                    'user_id' => $purchasedUser->id, // sale purchase user
                    'type' => 'LESS_LEVEL_COMMISSION',
                    'amount' => $less_level_commissions,
                ]);
                $package->adminEarnings()->create([
                    'user_id' => $purchasedUser->id, // sale purchase user
                    'type' => 'LESS_LEVEL_COMMISSION',
                    'amount' => $total_profit_for_company_from_package,
                ]);

                $admin_wallet = AdminWallet::firstOrCreate(
                    ['wallet_type' => 'LESS_LEVEL_COMMISSION'],
                    ['balance' => 0]
                );

                $admin_wallet->increment('balance', $less_level_commissions);
                $admin_wallet->increment('balance', $total_profit_for_company_from_package);
            }


            $package->adminEarnings()->create([
                'user_id' => $purchasedUser->id, // sale purchase user
                'type' => 'GIFT',
                'amount' => $allocated_for_gift,
            ]);
            $admin_wallet = AdminWallet::firstOrCreate(
                ['wallet_type' => 'GIFT'],
                ['balance' => 0]
            );
            $admin_wallet->increment('balance', $allocated_for_gift);


            $package->adminEarnings()->create([
                'user_id' => $purchasedUser->id, // sale purchase user
                'type' => 'BONUS_PENDING',
                'amount' => $rank_bonus_percentage,
            ]);
            $admin_wallet = AdminWallet::firstOrCreate(
                ['wallet_type' => 'BONUS_PENDING'],
                ['balance' => 0]
            );
            $admin_wallet->increment('balance', $rank_bonus_percentage);

            $package->update(['commission_issued_at' => now()]);
        });


        CalculateBvPointsJob::dispatch($this->purchasedUser, $this->package)->onConnection('sync')->afterResponse();
        DispatchPendingBvPointsJob::dispatch()->onConnection('sync')->afterResponse();

        Log::channel('daily')->info(
            "SaleLevelCommissionJob Exited | PURCHASE PACKAGE: {$this->package->id} | " .
            "USER : {$this->purchasedUser->username} - {$this->purchasedUser->id}"
        );
    }
}
