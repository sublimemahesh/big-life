<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Seeder;

class PackageSeeder extends Seeder
{
    public const debugPackages = [
        ['name' => 'Debug 01', 'slug' => 'debug-01', 'amount' => 10, 'bv_points' => 20, 'gas_fee' => 0, 'daily_max_out_limit' => 20, 'month_of_period' => 15, 'daily_leverage' => 1, 'is_active' => true],
        ['name' => 'Debug 01', 'slug' => 'debug-02', 'amount' => 20, 'bv_points' => 40, 'gas_fee' => 0, 'daily_max_out_limit' => 40, 'month_of_period' => 15, 'daily_leverage' => 1, 'is_active' => true]
    ];

    public const livePackages = [
        ['name' => 'Basic 01', 'slug' => 'package-01', 'amount' => 100, 'bv_points' => 20, 'gas_fee' => 10, 'daily_max_out_limit' => 200, 'month_of_period' => 15, 'daily_leverage' => 1, 'is_active' => true],
        ['name' => 'Basic 02', 'slug' => 'package-02', 'amount' => 250, 'bv_points' => 50, 'gas_fee' => 10, 'daily_max_out_limit' => 500, 'month_of_period' => 15, 'daily_leverage' => 1, 'is_active' => true],
        ['name' => 'Basic 03', 'slug' => 'package-03', 'amount' => 500, 'bv_points' => 100, 'gas_fee' => 10, 'daily_max_out_limit' => 1000, 'month_of_period' => 15, 'daily_leverage' => 1, 'is_active' => true],
        ['name' => 'Basic 04', 'slug' => 'package-04', 'amount' => 1000, 'bv_points' => 200, 'gas_fee' => 25, 'daily_max_out_limit' => 2000, 'month_of_period' => 15, 'daily_leverage' => 1, 'is_active' => true],
        ['name' => 'Standard 01', 'slug' => 'standard-01', 'amount' => 2500, 'bv_points' => 500, 'gas_fee' => 25, 'daily_max_out_limit' => 5000, 'month_of_period' => 15, 'daily_leverage' => 1, 'is_active' => true],
        ['name' => 'Standard 02', 'slug' => 'standard-02', 'amount' => 5000, 'bv_points' => 1000, 'gas_fee' => 50, 'daily_max_out_limit' => 10000, 'month_of_period' => 15, 'daily_leverage' => 1, 'is_active' => true],
        ['name' => 'Standard 03', 'slug' => 'standard-03', 'amount' => 10000, 'bv_points' => 2000, 'gas_fee' => 50, 'daily_max_out_limit' => 20000, 'month_of_period' => 15, 'daily_leverage' => 1, 'is_active' => true],
        ['name' => 'Standard 04', 'slug' => 'standard-04', 'amount' => 25000, 'bv_points' => 4500, 'gas_fee' => 100, 'daily_max_out_limit' => 50000, 'month_of_period' => 15, 'daily_leverage' => 1, 'is_active' => true],
        ['name' => 'VIP 01', 'slug' => 'vip-01', 'amount' => 50000, 'bv_points' => 9000, 'gas_fee' => 100, 'daily_max_out_limit' => 100000, 'month_of_period' => 15, 'daily_leverage' => 1, 'is_active' => true],
        // Inactive
        ['name' => 'VIP 02', 'slug' => 'vip-02', 'amount' => 100000, 'bv_points' => 18000, 'gas_fee' => 125, 'daily_max_out_limit' => 200000, 'month_of_period' => 15, 'daily_leverage' => 1, 'is_active' => 0],
        ['name' => 'VIP 03', 'slug' => 'vip-03', 'amount' => 250000, 'bv_points' => 32000, 'gas_fee' => 125, 'daily_max_out_limit' => 500000, 'month_of_period' => 15, 'daily_leverage' => 1, 'is_active' => 0],
        ['name' => 'VIP 04', 'slug' => 'vip-04', 'amount' => 500000, 'bv_points' => 64000, 'gas_fee' => 125, 'daily_max_out_limit' => 1000000, 'month_of_period' => 15, 'daily_leverage' => 1, 'is_active' => 0]
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $packages = self::livePackages;
        if (config('app.debug')) {
            $packages = [...$packages, ...self::debugPackages];
        }

        DB::table('packages')->insert($packages);
    }
}
