<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\MaxedOutBvPoint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MaxedOutBvPointController extends Controller
{

    public function index()
    {
        $maxedOutBvPoints = MaxedOutBvPoint::where('user_id', Auth::id())
            ->with('purchasedPackage')
            ->orderBy('maxed_out_date', 'desc')
            ->paginate(15);

        return view('backend.user.bv-points.maxed-out-bv-points', compact('maxedOutBvPoints'));
    }
}
