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
        //SELECT * FROM `carts` WHERE `cart_id` IN (2,1)
        // $getdata['user'] = User::find($request->input('user_id'));
        $getdata = Cart::with('product','user')->get();
        // dd($getdata);
        $cart_id = explode(",", $request->order_cart_id);
        // dd($cart_id);  
        $d = $getdata->whereIn('cart_id',$cart_id);
        dd($d);

        if(!empty($getdata)){
            $add_data = OrderDetails::create($request->all());
            $add_data->order_user_id = $getdata->user_id;
            $add_data->order_product_id = $getdata->product_id;
            $add_data->order_cart_id = $getdata->cart_id;
            $add_data->quantity = $getdata->quantity;
            $add_data->total_order_price = $getdata->total_price;
            $add_data->save();
            $json['success'] = 1;
            $json['message'] = 'Order confirm Successfully.';
            $json['order_list'] = $add_data;
        }
        else{
            $json['success'] = 0;
            $json['message'] = 'Cart not found.';
        }

 	    echo json_encode($json);
	}
}
