<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Order;
use App\Models\OrderDetails;
use App\Models\Favourites;
use App\Models\Cart;
use App\User;
use Validator;
use Illuminate\Support\Str;
use File;
use DB;
use Carbon\Carbon;

class OrdersController extends Controller
{
    public function add_cart_to_order(Request $request)
	{
        //SELECT * FROM `carts` WHERE `cart_id` IN (2,1)
        // $cart_id = explode(",", $request->cart_id);
        $id = $request->cart_id;

        $order = Order::where('user_id',$request->user_id)->where('order_status','0')->first();
        // dd($order);
        // $myString = $order->cart_id;
        // $myArray = explode(',', $myString);
        // dd($myArray);
        // $getdata = Order::create($request->all());

        $cart = Cart::where('cart_id',$request->cart_id)->get();
        $user = User::where('id',$request->user_id)->first();
        // dd($user);
            if(!empty($order)){
                $order->cart_id = $request->cart_id;
                $order->total_price = $request->total_price;
                $order->save();
                // $order->total_price = $request->total_price;
                $json['status'] = 1;
                $json['message'] = 'Favourite Product add Successfully.';
                $json['order_list'] = $order;
            }
            else{
                $add_data = Order::create($request->all());
                $add_data->save();
                $json['status'] = 0;
                $json['message'] = 'Product or User not found.';
                $json['order_list'] = $add_data;
            }

 	    echo json_encode($json);
	}

    public function add_order(Request $request)
	{
       $getdata = Order::where('order_id',$request->order_id)->first();

        $token = $this->getToken(6);
        $code = 'EN'. $token . substr(strftime("%Y", time()),2);
        $delivery_date = Carbon::now()->addDays(3);

        $model_num = rand(1111111111,9999999999);
        $order_num = 'KL'.$model_num;
        $tracking_num = 'IW'.$model_num;

        if(!empty($getdata)){
            $add_data = OrderDetails::create($request->all());
            // dd($add_data->created_at->addDays(3));
            $add_data->order_id  = $request->order_id;
            $add_data->user_id  = $request->user_id;
            $add_data->tracking_num  = $tracking_num;
            $add_data->order_num  = $order_num;
            $add_data->customer_price = $request->customer_price;
            $add_data->total_price = $getdata->total_price;
            // $add_data->delivery_date = $delivery_date;
            $add_data->delivery_date = $add_data->created_at->addDays(3);
            $add_data->payment_method = $request->payment_method;
            $add_data->delivery_method = "3 days";
            $add_data->status = 0;
            $add_data->delivery_charge = 0;
            $add_data->discount = $request->discount;
            $add_data->total_quantity = $request->total_quantity;
            // dd($add_data);
            $add_data->save();
            $json['status'] = 1;
            $json['message'] = 'Order Confirm Successfully.';
            $json['order_list'] = $add_data;
        }
        else{
            $json['status'] = 0;
            $json['message'] = 'Data not found.';
        }

 	    echo json_encode($json);
	}

    public function order_list(Request $request)
	{
        $getresult  = OrderDetails::where('status',1)->where('user_id', '=' ,$request->user_id)->get();
        // dd($getresult);

        // $is_fav="";
        //     foreach($getresult as $p){
        //         // dd($getresult);
        //         $pid = $p->product_id;
        //         $fav  = Favourites::
        //             where('user_id', '=' ,$request->user_id)
        //             ->where('product_id', '=' ,$pid)->first();
        //             if(!empty($fav)){
        //                 $is_fav=$fav->status;
        //                 //dd($is_fav);
        //                 $p['is_fav']=$is_fav;
        //                 //dd($p);
        //             }else{
        //                 $p['is_fav']=0;
        //             }
        //     }

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

    public function order_details(Request $request)
	{
        if($request->user_id && $request->order_num){
            $getresult  = OrderDetails::with('user')
                ->where('order_num', '=' ,$request->order_num)->first();

            if(!empty($getresult)){
                $order_id = $getresult->order_id;
                $order = Order::find($order_id);
                $cart_id = $order->cart_id;
                $array_cart_id = explode(',', $cart_id);
                $cart = Cart::whereIn('cart_id',$array_cart_id)->get();
                foreach($cart as $c){
                    $array_product_id[] = $c->product_id; 
                }

                // dd($array_product_id);
                // $p_id = [3,6];
                $product = Product::with('images','size','color')->whereIn('id',$array_product_id)->get();
            
                $getresult['product_list'] = $product;
                $json['status'] = 1;
                $json['message'] = 'Order Details Loaded Successfully.';
                $json['order_list'] = $getresult;
            }
            else{
                $json['status'] = 0;
                $json['message'] = 'Data not Found.';
            }
        }
        else{
            $json['status'] = 0;
            $json['message'] = 'Fill Required Data.';
        }
        echo json_encode($json);
	}


    ### changes #####
    public function Add_cart_to_Order_seperate_entry(Request $request)
	{
        //SELECT * FROM `carts` WHERE `cart_id` IN (2,1)
        $cart_id = explode(",", $request->cart_id);
        // dd($cart_id);  
       
            foreach($cart_id as $c){
                $order_data = Order::where('cart_id', '=',$c)
                ->where('user_id', '=', trim($request->user_id))
                // ->where('status', '=', '0')
                ->get();

                foreach($order_data as $order){
                    // dd($order['cart_id']);
                    // dd($order->status ==0);
                    if($order->status ==0){
                        $cart[] = $c;
                            $order->cart_id = $c;
                            $order->user_id = $request->user_id;
                            $order->total_price = $request->total_price;
                            $order->save();
                            $json['success'] = 1;
                            $json['message'] = 'Order confirm Successfully.';
                            // $json['order_list'] = $order;
                    }
                    else{
                        // dd($order);
                            $order_add = Order::crete([
                            'cart_id'        => $c,
                            'user_id'     => $request->user_id,
                            'total_price'    => $request->total_price,
                            ]);
                            $json['success'] = 1;
                            $json['message'] = 'Order confirm Successfully.';
                            // $json['order_list'] = $order_add;
                        // dd($order_add);
                    }
                }
            }
            // dd($order_data);

 	    echo json_encode($json);
	}

    public function AddOrder_old(Request $request)
	{
        $order_add['product'] = Product::find($request->input('product_id'));
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

    public function order_list_backup(Request $request)
	{
        $getresult  = Order::with('product')->where('status',1)->where('user_id', '=' ,$request->user_id)->get();

        $is_fav="";
            foreach($getresult as $p){
                // dd($getresult);
            $pid = $p->product_id;
                $fav  = Favourites::
                    where('user_id', '=' ,$request->user_id)
                    ->where('product_id', '=' ,$pid)->first();
                    if(!empty($fav)){
                        $is_fav=$fav->status;
                        //dd($is_fav);
                        $p['is_fav']=$is_fav;
                        //dd($p);
                    }else{
                        $p['is_fav']=0;
                    }
            }

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

    public function order_details_backup(Request $request)
	{
        if($request->user_id && $request->order_num){
            $getresult  = Order::with('product','user')
                ->where('order_num', '=' ,$request->order_num)->get();
            foreach($getresult as $data){
                $u_id = $data->user_id;
                $p_id[] = $data->product_id;
                $c[] = $data->color;
                $s[] = $data->size;
                $q[] = $data->quantity;
                $sum = array_sum($q);
            }
            // dd($c);
            $result = array();

            $order  = OrderDetails::with('product','user')
            ->where('order_num', '=' ,$request->order_num)->first();
            $result['order_num'] = $order->order_num;
            $result['delivery_date'] = $order->delivery_date;
            $result['tracking_num'] = $order->tracking_num;
            $result['total_quantity'] = $sum;
            $result['payment_method'] = $order->payment_method;
            $result['delivery_method'] = $order->delivery_method;
            $result['discount'] = $order->discount;

            $user_array = array();
            $user  = User::where('id',$request->user_id)->get();
            foreach ($user as $valuea) {
                $datax['id'] 			= $valuea->id;
                $datax['address']   = !empty($valuea->address) ? $valuea->address : '';
                $datax['city']   = !empty($valuea->city) ? $valuea->city : '';
                $datax['state']   = !empty($valuea->state) ? $valuea->state : '';
                $datax['zip_code']   = !empty($valuea->zip_code) ? $valuea->zip_code : '';
                $datax['contry']   = !empty($valuea->contry) ? $valuea->contry : '';
                $user_array[] = $datax;
            }
            $result['user_address'] = $user_array;

            $product_array = array();
            $product = Product::with('images','size','color')->whereIn('id',$p_id)->get();
            // $product = Product::whereIn('id',$p_id)->get();
            // foreach ($product as  $key=>$valueb) {
            //     $datay['id'] 		= $valueb->id;
            //     $datay['product_name']		= !empty($valueb->product_name) ? $valueb->product_name : '';
            //     $datay['quantty']		= !empty($q[$key]) ? $q[$key] : '';
            //     $datay['color']		= !empty($c[$key]) ? $c[$key] : '';
            //     $datay['size']		= !empty($s[$key]) ? $s[$key] : '';
            //     $product_array[] = $datay;
            // }
            $result['product_list'] = $product;
        
            $json['status'] = 1;
            $json['message'] = 'Order Details Loaded Successfully.';
            $json['order_list'] = $result;
        }
        else{
            $json['status'] = 0;
            $json['message'] = 'Fill Required Data.';
        }
        echo json_encode($json);
	}

    public function order_details_ordertable(Request $request)
	{
        if($request->user_id && $request->order_num){
            $getresult  = Order::with('product','user')
                ->where('order_num', '=' ,$request->order_num)->get();
            foreach($getresult as $data){
                $u_id = $data->user_id;
                $p_id[] = $data->product_id;
                $c[] = $data->color;
                $s[] = $data->size;
                $q[] = $data->quantity;
                $sum = array_sum($q);
            }
            // dd($c);
            $result = array();

            $order  = Order::with('product','user')
            ->where('order_num', '=' ,$request->order_num)->first();
            $result['order_num'] = $order->order_num;
            $result['delivery_date'] = $order->delivery_date;
            $result['tracking_num'] = $order->tracking_num;
            $result['total_quantity'] = $sum;
            $result['payment_method'] = $order->payment_method;
            $result['delivery_method'] = $order->delivery_method;
            $result['discount'] = $order->discount;

            $user_array = array();
            $user  = User::where('id',$request->user_id)->get();
            foreach ($user as $valuea) {
                $datax['id'] 			= $valuea->id;
                $datax['address']   = !empty($valuea->address) ? $valuea->address : '';
                $datax['city']   = !empty($valuea->city) ? $valuea->city : '';
                $datax['state']   = !empty($valuea->state) ? $valuea->state : '';
                $datax['zip_code']   = !empty($valuea->zip_code) ? $valuea->zip_code : '';
                $datax['contry']   = !empty($valuea->contry) ? $valuea->contry : '';
                $user_array[] = $datax;
            }
            $result['user_address'] = $user_array;

            $product_array = array();
            $product = Product::whereIn('id',$p_id)->get();
            foreach ($product as  $key=>$valueb) {
                $datay['id'] 		= $valueb->id;
                $datay['product_name']		= !empty($valueb->product_name) ? $valueb->product_name : '';
                $datay['quantty']		= !empty($q[$key]) ? $q[$key] : '';
                $datay['color']		= !empty($c[$key]) ? $c[$key] : '';
                $datay['size']		= !empty($s[$key]) ? $s[$key] : '';
                $product_array[] = $datay;
            }
            $result['product_list'] = $product_array;
        
            $json['status'] = 1;
            $json['message'] = 'Order Details Loaded Successfully.';
            $json['order_list'] = $result;
        }
        else{
            $json['status'] = 0;
            $json['message'] = 'Fill Required Data.';
        }
        echo json_encode($json);
	}

    public function order_details_old(Request $request)
	{
        if($request->user_id){
            $getresult  = Order::with('product','user')
            ->where('order_num', '=' ,$request->order_num)->get();

            foreach($getresult as $data){
                $q[] = $data->quantity;
                $sum = array_sum($q);
            }
            foreach($getresult as $getsum){
                 $getsum['total_quantity'] = $sum;
            }
        // dd($sum);
            if(!empty($getresult->count() > 0)){
                $json['success'] = 1;
                $json['message'] = 'Order list loaded Successfully.';
                $json['order_list'] = $getresult;
            }
            else{
                $json['success'] = 0;
                $json['message'] = 'order number not match.';
            }
        }
        else{
            $json['success'] = 0;
            $json['message'] = 'Fill required data.';
        }

 	    echo json_encode($json);
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

    public function AddOrder_backup(Request $request)
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
