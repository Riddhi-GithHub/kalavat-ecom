<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\Product;
use App\Models\Category;
use App\Models\Favourites;
use App\User;
use Validator;
use Str;
use File;
use DB;

class FavouritesController extends BaseController
{

    // --------- using base controller ----start-------
    public function add_favourite_(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'product_id' => 'required',
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }

        $product = Product::find($request->input('product_id'));

        if(!empty($product)){
                $fav = Favourites::create($request->all());
                $fav->product_id = $input['product_id'];
                $fav->save();
                return $this->sendResponse($fav->toArray(), 'Product add to favourite sccessfully.');
            }
        else {
            return $this->sendError('product not found');  
        }
    }

    public function favourite_list(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'product_id' => 'required',
        ]);

        $product = Product::find($request->input('product_id'));
        $fav = Favourites::with('product','product.category')->where('product_id',$request->input('product_id'))->get();

        if(!empty($product)){
            if($validator->fails()){
                return $this->sendError('Validation Error.', $validator->errors()); 
                }elseif(!empty($fav->count() > 0)){
                    return $this->sendResponse($fav,'Favourite product retrieved successfully.');
                }
                else{
                    return $this->sendError('Favourite product not found.'); 
                } 
            }
        else{
            return $this->sendError('Product not found.', $validator->errors()); 
        }
    }

    // --------- using base controller ----finish-------



    public function AddFavouriteProduct(Request $request)
	{
        if (!empty($request->product_id && $request->user_id && $request->status)) {
            $product = Product::find($request->input('product_id'));
            $user = User::find($request->input('user_id'));
            // dd(!empty($product && $user));
            if(!empty($product && $user)){
                $data = Favourites::where('product_id', '=', trim($request->product_id))
                ->where('user_id', '=', trim($request->user_id))
                // ->where('status', '=', trim($request->status))
                ->first();
                if (!empty($data)) {
                    $data->status  = $request->status;
                    $data->save();
                    $json['success'] = 1;
                    $json['message'] = 'Added to wishlist product status change Successfully.';
                    $json['favourite_list'] = $data;
                }else{
                    $getdata = Favourites::create($request->all());
                    $getdata->save();
                    $json['success'] = 1;
                    $json['message'] = 'Added to wishlist.';
                    $json['favourite_list'] = $getdata;
                }
            }
            else{
            $json['success'] = 0;
            $json['message'] = 'User Or Product Not Found!';
            }
        }
        else{
        $json['success'] = 0;
        $json['message'] = 'Fill user_id, product_id and status';
        }
        echo json_encode($json);
    }

    public function getFavouriteList(Request $request)
	{
	    // $result  = array();
		// $getresult  = Favourites::with('user','product')->where('user_id', '=' ,$request->user_id)->where('product_id', '=' ,$request->product_id)->get();
		// $getresult  = Favourites::with('product')->where('user_id', '=' ,$request->user_id)->get();
        $getresult  = Favourites::with('product','product.images','product.color','product.size')->where('status',1)->where('user_id', '=' ,$request->user_id)->get();

        if(!empty($getresult->count() > 0)){
            $json['success'] = 1;
            $json['message'] = 'Favourite list loaded Successfully.';
            $json['favourite_list'] = $getresult;
        }
        else{
            $json['success'] = 0;
            $json['message'] = 'Favourite Product not found.';
        }

 	    echo json_encode($json);
	}

    public function deleteFavouriteProdcut(Request $request)
	{
        if (!empty($request->product_id && $request->user_id)) {
            // dd(!empty($product && $user));
                $data = Favourites::where('product_id', '=', trim($request->product_id))
                ->where('user_id', '=', trim($request->user_id))
                // ->where('status', '=', trim($request->status))
                ->first();
                // dd(!empty($data));
                if (!empty($data)) {
                    $data->status  = '0';
                    $data->save();
                    $json['success'] = 1;
                    $json['message'] = 'Favourite prodcut deleted Successfully';
                    $json['favourite_list'] = $data;
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
   
    public function UpdateFavouriteProduct(Request $request)
	{
        if (!empty($request->product_id && $request->user_id)) {
            $product = Product::find($request->input('product_id'));
            $user = User::find($request->input('user_id'));
            if(!empty($product && $user)){
                $data = Favourites::where('product_id', '=', trim($request->product_id))
                ->where('user_id', '=', trim($request->user_id))
                // ->where('status', '=', trim($request->status))
                ->first();
                if(!empty($data))
                {
                    $data->status  = trim($request->status);
                    // $data->status  = '0';
                    $data->save();
                    $json['success'] = 1;
                    $json['message'] = 'Favourite prodcut status change Successfully';
                    $json['favourite_list'] = $data;
                }
                else{
                    $json['success'] = 0;
                    $json['message'] = 'Product not found.';
                }
            }
            else{
            $json['success'] = 0;
            $json['message'] = 'User Or Product Not Found!';
            }
        }
        else{
        $json['success'] = 0;
        $json['message'] = 'Fill user_id and product_id';
        }
        echo json_encode($json);
    }
}
