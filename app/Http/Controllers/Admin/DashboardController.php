<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\SuperAdmin\DashboardController as SuperAdminDashboard;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {

//        return (new SuperAdminDashboard())->index($request);

        //TODO: Develop admin dashboard
        return view('backend.admin.dashboard');
    }
}
