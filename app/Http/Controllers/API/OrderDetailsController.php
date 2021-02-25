<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Order;
use App\Models\OrderDetails;
use App\Models\Cart;
use App\User;
use Validator;
use Str;
use File;
use DB;

class OrderDetailsController extends Controller
{
    public function Add_cart_to_Order(Request $request)
	{
        $getdata['user'] = User::find($request->input('user_id'));
        
        if(!empty($getdata)){
            $add_data = OrderDetails::create($request->all());
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
}
