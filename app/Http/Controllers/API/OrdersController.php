<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Order;
use App\Models\OrderDetails;
use App\User;
use Validator;
use Str;
use File;
use DB;
use Carbon\Carbon;

class OrdersController extends Controller
{
    public function AddOrder_old(Request $request)
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
            $json['success'] = 1;
            $json['message'] = 'Order list loaded Successfully.';
            $json['order_list'] = $getresult;
        }
        else{
            $json['success'] = 0;
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


    private function getToken($length){    
        $token = "";
        $codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $codeAlphabet = "abcdefghijklmnopqrstuvwxyz";
        $codeAlphabet.= "0123456789";
        // mt_srand($seed);      // Call once. Good since $application_id is unique.

        for($i=0;$i<$length;$i++){
            $token .= $codeAlphabet[mt_rand(0,strlen($codeAlphabet)-1)];
        }
        return $token;
    }

    public function AddOrder(Request $request)
	{
       $getdata = OrderDetails::find($request->input('order_detail_id'));

        $token = $this->getToken(6);
        $code = 'EN'. $token . substr(strftime("%Y", time()),2);

        // $date =  $getdata->created_at->format('d-m-Y');

        $delivery_date = Carbon::now()->addDays(3);
    //    $date =  $getdata->created_at->format('d-m-Y');

        if(!empty($getdata)){
            $add_data = Order::create($request->all());
            $add_data->user_id  = $getdata->order_user_id;
            $add_data->product_id  = $getdata->order_product_id;
            $add_data->tracking_num  = $code;
            $add_data->quantity = $getdata->quantity;
            $add_data->total_price = $getdata->total_order_price;
            $add_data->delivery_date = $delivery_date;
            $add_data->save();
            $json['status'] = 1;
            $json['message'] = 'Order add Successfully.';
            $json['order_list'] = $add_data;
        }
        else{
            $json['status'] = 0;
            $json['message'] = 'Product or User not found.';
        }

 	    echo json_encode($json);
	}

}
