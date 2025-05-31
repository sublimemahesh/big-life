<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MaxedOutBvPoint;
use App\Models\User;
use Illuminate\Http\Request;

class MaxedOutBvPointController extends Controller
{
    public function index(Request $request)
    {
        $query = MaxedOutBvPoint::with(['user', 'purchasedPackage'])->orderBy('maxed_out_date', 'desc');

        // Filter by username if provided
        if ($request->has('username')) {
            $query->whereRelation('user', 'username', $request->username);
        }

        $maxedOutBvPoints = $query->paginate(15);

        return view('backend.admin.bv-points.maxed-out-bv-points', compact('maxedOutBvPoints'));
    }
}
