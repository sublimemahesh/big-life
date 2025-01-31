<?php

namespace App\Http\Controllers\Admin;

use App\Enums\BinaryPlaceEnum;
use App\Http\Controllers\Controller;
use App\Models\BvPointEarning;
use App\Models\BvPointReward;
use App\Models\Earning;
use Auth;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class BvPointController extends Controller
{
    /**
     * @throws \Exception
     */
    public function earnings(Request $request)
    {
        abort_if(Gate::denies('bv-reports.viewAny'), Response::HTTP_FORBIDDEN);
        if ($request->wantsJson()) {
            $earnings = BvPointEarning::filter()
                ->with('purchasedPackage', 'user', 'purchaser')
                ->when(!empty($request->get('user_id')), function ($query) use ($request) {
                    $query->where('user_id', $request->get('user_id'));
                });

            return DataTables::of($earnings)
                ->addColumn('user', fn($point) => $point->user->username)
                ->addColumn('from', fn($point) => $point->purchaser->username)
                ->addColumn('package', fn(BvPointEarning $point) => $point->purchasedPackage->package_info_json->name ?? "N/A")
                ->addColumn('left', fn(BvPointEarning $point) => $point->left_point)
                ->addColumn('right', fn($point) => $point->right_point)
                ->addColumn('date', fn($point) => $point->created_at->format('Y-m-d H:i:s'))
                ->make();
        }

        return view('backend.admin.bv-points.bvpoints-report');
    }

    public function rewards(Request $request)
    {
        abort_if(Gate::denies('bv-reports.viewAny'), Response::HTTP_FORBIDDEN);
        if ($request->wantsJson()) {
            $earnings = BvPointReward::filter()
                ->with('user')
                ->whereNull('parent_id')
                ->when(!empty($request->get('user_id')), function ($query) use ($request) {
                    $query->where('user_id', $request->get('user_id'));
                });

            return DataTables::of($earnings)
                ->addColumn('user', fn($point) => $point->user->username)
                ->addColumn('points', fn($point) => $point->bv_points)
                ->addColumn('amount', fn($point) => number_format($point->amount, 2))
                ->addColumn('paid', fn($point) => number_format($point->paid, 2))
                ->addColumn('lost', fn($point) => number_format($point->lost_amount, 2))
                ->addColumn('date', fn($point) => $point->created_at->format('Y-m-d H:i:s'))
                ->make();
        }

        return view('backend.admin.bv-points.bvpoints-rewards');
    }
}
