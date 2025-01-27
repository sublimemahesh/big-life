<?php

namespace App\Console\Commands;

use App\Jobs\CalculateBvPointsJob;
use App\Jobs\DispatchPendingBvPointsJob;
use App\Models\PurchasedPackage;
use Illuminate\Console\Command;
use Symfony\Component\Console\Command\Command as CommandAlias;

class RefreshBvPointCalculation extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'refresh:bv-points';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Refresh Missing bv points calculation jobs';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info("Refresh Missing bv points calculation jobs");
        
        PurchasedPackage::with('user')
            ->whereDoesntHave('bvPointEarning')
            ->oldest()
            ->chunkById(100, function ($packages) {
                foreach ($packages as $package) {
                    CalculateBvPointsJob::dispatch($package->user, $package);
                }
            });

        $this->info("Dispatch Pending BvPoints Rewards");
        DispatchPendingBvPointsJob::dispatch();

        return CommandAlias::SUCCESS;
    }
}
