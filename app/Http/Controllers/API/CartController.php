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
        $getdata['product'] = Product::find($request->input('product_id'));
        $getdata['user'] = User::find($request->input('user_id'));

        if(!empty($getdata)){
            $getdata = Cart::create($request->all());
            $getdata->status = 1;
            $getdata->save();
            $json['status'] = 1;
            $json['message'] = 'Product add to Cart Successfully.';
            $json['cart_list'] = $getdata;
        }
        else{
            $json['status'] = 0;
            $json['message'] = 'Product or User not found.';
        }

 	    echo json_encode($json);
	}

    public function getCartList(Request $request)
	{
        $getresult  = Cart::with('product')->where('status',1)->where('user_id', '=' ,$request->user_id)->get();
        // $getresult  = Favourites::with('product')->where('status',1)->where('user_id', '=' ,$request->user_id)->get();

        if(!empty($getresult->count() > 0)){
            $json['status'] = 1;
            $json['message'] = 'Cart list loaded Successfully.';
            $json['cart_list'] = $getresult;
        }
        else{
            $json['status'] = 0;
            $json['message'] = 'Product not found.';
        }

 	    echo json_encode($json);
	}

    public function deleteCartProdcut(Request $request)
    {
        $data  = Cart::where('status',1)->find($request->cart_id);
            if(!empty($data))
            {
                // $recode_update->status  = trim($request->status);
                $data->status  = '0';
                $data->save();
                $json['status'] = 1;
                $json['message'] = 'Favourite prodcut deleted Successfully';
            }
        else{
                $json['status'] = 0;
                $json['message'] = 'Product not found.';
            }
		echo json_encode($json);
    }
}
