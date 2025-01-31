<?php

namespace App\Http\Controllers\User;

use App\Enums\BinaryPlaceEnum;
use App\Http\Controllers\Controller;
use App\Models\BvPointEarning;
use App\Models\BvPointReward;
use App\Models\Earning;
use Auth;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class BvPointController extends Controller
{
    /**
     * @throws \Exception
     */
    public function earnings(Request $request)
    {
        if ($request->wantsJson()) {
            $earnings = BvPointEarning::filter()
                ->with('purchasedPackage', 'purchaser')
                ->where('user_id', Auth::user()->id);

            return DataTables::of($earnings)
                ->addColumn('from', fn($point) => $point->purchaser->username)
                ->addColumn('package', fn(BvPointEarning $point) => $point->purchasedPackage->package_info_json->name ?? "N/A")
                ->addColumn('left', fn(BvPointEarning $point) => $point->left_point)
                ->addColumn('right', fn($point) => $point->right_point)
                ->addColumn('date', fn($point) => $point->created_at->format('Y-m-d H:i:s'))
                ->make();
        }

//        $left_point = BvPointEarning::where('user_id', Auth::user()->id)->sum('left_point');
//        $right_point = BvPointEarning::where('user_id', Auth::user()->id)->sum('right_point');
        $left_point = Auth::user()->left_points_balance;
        $right_point = Auth::user()->right_points_balance;
        $balanced_point = BvPointReward::where('user_id', Auth::user()->id)
            ->whereNull('parent_id')
            ->sum('bv_points');

        $earned_usdt = BvPointReward::where('user_id', Auth::user()->id)
            ->where('status', 'claimed')
            ->whereNull('parent_id')
            ->sum('paid');

        $pending_usdt = BvPointReward::where('user_id', Auth::user()->id)
            ->where('status', 'pending')
            ->whereNull('parent_id')
            ->sum('paid');

        $expired_usdt = BvPointReward::where('user_id', Auth::user()->id)
            //->whereNotNull('parent_id')
            ->where('status', 'expired')
            ->sum('amount');

        $left_direct_sales = Auth::user()->directSales()->where('position', BinaryPlaceEnum::LEFT->value)->count();
        $right_direct_sales = Auth::user()->directSales()->where('position', BinaryPlaceEnum::RIGHT->value)->count();

        return view('backend.user.bv-points.bvpoints-report', compact(
            'left_point',
            'right_point',
            'balanced_point',
            'earned_usdt',
            'pending_usdt',
            'expired_usdt',
            'left_direct_sales',
            'right_direct_sales'
        ));
    }

    public function rewards(Request $request)
    {
        if ($request->wantsJson()) {
            $earnings = BvPointReward::with('user')
                ->whereNull('parent_id')
                ->where('user_id', Auth::user()->id);

            return DataTables::of($earnings)
                ->addColumn('points', fn($point) => $point->bv_points)
                ->addColumn('amount', fn($point) => number_format($point->amount, 2))
                ->addColumn('paid', fn($point) => number_format($point->paid, 2))
                ->addColumn('lost', fn($point) => number_format($point->lost_amount, 2))
                ->addColumn('date', fn($point) => $point->created_at->format('Y-m-d H:i:s'))
                ->make();
        }

        return view('backend.user.bv-points.bvpoints-rewards');
    }
}
