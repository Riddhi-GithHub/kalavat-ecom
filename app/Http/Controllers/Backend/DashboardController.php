<?php

namespace App\Http\Controllers\Backend;
// use App\Models\UsersModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function dashboard_list(Request $request)
    {
    	$data['meta_title'] = 'Dashboard List';
    	return view('backend.dashboard.list', $data);
    }
}