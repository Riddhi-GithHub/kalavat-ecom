<?php

namespace App\Http\Controllers\Backend;
// use App\Models\UsersModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Sub_Category;
use App\Models\Order;
use App\User;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function dashboard_list(Request $request)
    {
        $data['user'] = User::count();
        $data['category'] = Category::count();
        $data['subcategory'] = Sub_Category::count();
        $data['product'] = Product::count();
        $data['todayorder'] = Order::whereDate('created_at',Carbon::today())->where('status',0)->count();
        $data['totalorder'] = Order::count();
    	$data['meta_title'] = 'Dashboard List';
    	return view('backend.dashboard.list', $data);
    }

}