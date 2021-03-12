<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Favourites;
use App\Models\Cart;
use App\User;
use Validator;
use Str;
use File;
use DB;

class CartController extends Controller
{

    public function addProductToCart(Request $request)
	{
        if (!empty($request->product_id && $request->user_id && $request->status)) {
            $product = Product::find($request->input('product_id'));
            $user = User::find($request->input('user_id'));
            // dd(!empty($product && $user));
            if(!empty($product && $user)){
                $data = Cart::where('product_id', '=', trim($request->product_id))
                ->where('user_id', '=', trim($request->user_id))
                // ->where('status', '=', trim($request->status))
                ->first();
                if (!empty($data)) {
                    $data->status  = $request->status;
                    $data->color  = $request->color;
                    $data->size  = $request->size;
                    $data->quantity  = $request->quantity;
                    $data->total_price  = $request->total_price;
                    $data->save();
                    $json['success'] = 1;
                    $json['message'] = 'Product added into Cart Successfully.';
                    $json['cart_list'] = $data;
                }else{
                    $getdata = Cart::create($request->all());
                    $getdata->save();
                    $json['success'] = 1;
                    $json['message'] = 'Product added  into Cart Successfully.';
                    $json['cart_list'] = $getdata;
                }
            }
            else{
            $json['success'] = 0;
            $json['message'] = 'User Or Product Not Found!';
            }
        }
        else{
        $json['success'] = 0;
        $json['message'] = 'Fill Required data';
        }
        echo json_encode($json);
    }

    public function getCartList(Request $request)
	{
        $getresult  = Cart::with('product','product.images')->where('status',1)->where('user_id', '=' ,$request->user_id)->get();
        // $getresult  = Favourites::with('product')->where('status',1)->where('user_id', '=' ,$request->user_id)->get();

        if(!empty($getresult->count() > 0)){
            $json['success'] = 1;
            $json['message'] = 'Cart list loaded Successfully.';
            $json['cart_list'] = $getresult;
        }
        else{
            $json['success'] = 0;
            $json['message'] = 'Product not found.';
        }

 	    echo json_encode($json);
	}

    public function deleteCartProdcut(Request $request)
    {
        if (!empty($request->product_id && $request->user_id)) {
            // dd(!empty($product && $user));
                $data = Cart::where('product_id', '=', trim($request->product_id))
                ->where('user_id', '=', trim($request->user_id))
                // ->where('status', '=', trim($request->status))
                ->first();
                // dd(!empty($data));
                if (!empty($data)) {
                    $data->status  = '0';
                    $data->save();
                    $json['success'] = 1;
                    $json['message'] = 'Favourite prodcut deleted Successfully';
                }else{
                    $json['success'] = 0;
                    $json['message'] = 'Product not found.';
                }
        }
        else{
        $json['success'] = 0;
        $json['message'] = 'Fill Required Data';
        }
        echo json_encode($json);
    }
}
