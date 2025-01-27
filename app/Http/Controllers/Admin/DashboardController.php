<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {

        return (new \App\Http\Controllers\SuperAdmin\DashboardController())->index($request);

        //TODO: Develop Super admin dashboard
        //return view('backend.super_admin.dashboard');
    }
}
