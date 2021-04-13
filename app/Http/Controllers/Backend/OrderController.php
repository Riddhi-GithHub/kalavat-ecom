<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderDetails;
use App\Models\Cart;
use App\Models\Product;

class OrderController extends Controller
{
  
    public function index(Request $request)
    {
        $getrecord = OrderDetails::orderBy('order_detail_id', 'desc')->select('order_details.*');;
        // $getrecord = $getrecord->join('products', 'orders.order_product_id', '=', 'products.id');
        $getrecord = $getrecord->join('users', 'order_details.user_id', '=', 'users.id');

    	if (!empty($request->order_detail_id )) {
			$getrecord = $getrecord->where('order_detail_id', '=', $request->order_detail_id);
		}

        if (!empty($request->tracking_num)) {
			$getrecord = $getrecord->where('tracking_num', '=', $request->tracking_num);
		}

        if (!empty($request->fullname)) {
			$getrecord = $getrecord->where('fullname', 'like', '%' . $request->fullname . '%');
		}

		if (!empty($request->product_name)) {
			$getrecord = $getrecord->where('product_name', 'like', '%' . $request->product_name . '%');
		}
    	// Search Box End
    	$getrecord = $getrecord->paginate(40);
    	$data['getrecord'] = $getrecord;
    	$data['meta_title'] = 'Order List';
    	return view('backend.order.list', $data);  
    }

    public function OderschangeStatus(Request $request)
    {
        // echo "string";
        // die();
        // $changeStatus = Order::find($request->status_change_id);
        $changeStatus = OrderDetails::find($request->status_change_id);

        $changeStatus->status = $request->status_id;
         //dd($changeStatus->status);
        $changeStatus->save();
        
        $json['success'] = true;
        echo json_encode($json);
    }

    public function get_product($id)
    {
        $order_detail = OrderDetails::find($id);
        $order        = Order::find($order_detail->order_id);
        // $cart_id = $order->cart_id;
        $array_cart_id = explode(',', $order->cart_id);
        $cart = Cart::whereIn('cart_id',$array_cart_id)->get();
            foreach($cart as $c){
                $array_product_id[] = $c->product_id; 
            }
        $product_list = Product::whereIn('id',$array_product_id)->get();
        $data['product_list'] = $product_list;
        $data['order_detail'] = $order_detail;
        $data['meta_title'] = "View Order";
        return view('backend.order.view', $data);
    }

    
}
