<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Order;
use App\User;
use Validator;
use Str;
use File;
use DB;

class OrdersController extends Controller
{
    public function AddOrder(Request $request)
	{
        $getdata['product'] = Product::find($request->input('product_id'));
        $getdata['user'] = User::find($request->input('user_id'));
        
        if(!empty($getdata)){
            $add_data = Order::create($request->all());
            $add_data->save();
            $json['status'] = 1;
            $json['message'] = 'Favourite Product add Successfully.';
            $json['order_list'] = $add_data;
        }
        else{
            $json['status'] = 0;
            $json['message'] = 'Product or User not found.';
        }

 	    echo json_encode($json);
	}

    public function ListOrder(Request $request)
	{
        $getresult  = Order::with('product')->where('status',1)->where('user_id', '=' ,$request->user_id)->get();

        if(!empty($getresult->count() > 0)){
            $json['status'] = 1;
            $json['message'] = 'Order list loaded Successfully.';
            $json['order_list'] = $getresult;
        }
        else{
            $json['status'] = 0;
            $json['message'] = 'User Order not found.';
        }

 	    echo json_encode($json);
    }

    public function EditOrder(Request $request)
	{

    }

    public function DeleteOrder(Request $request)
	{

    }
}
