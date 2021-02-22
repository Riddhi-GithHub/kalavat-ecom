<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\Product;
use App\Models\Category;
use App\Models\Favourites;
use Validator;
use Str;
use File;
use DB;

class FavouritesController extends BaseController
{

    // --------- using base controller ----start-------
    public function add_favourite(Request $request)
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

    // public function delete_favourite(Request $request)
    // {
    //     $input = $request->all();
    //     $validator = Validator::make($input,[
    //         'fav_id' => 'required',
    //         'product_id' => 'required',
    //         ]);

    //     if($validator->fails()){
    //         return $this->sendError('Validation Error.', $validator->errors());       
    //     }
        
    //     $product = Product::find($request->input('product_id'));
    //     $fav = Favourites::where('fav_id ',$request->fav_id )->where('product_id',$request->product_id)->get();
          
    //     if(!empty($product)){
    //         if($validator->fails()){
    //             return $this->sendError('Validation Error.', $validator->errors()); 
    //         }elseif(!empty($fav)){
    //             return $this->sendResponse($fav,'favourite product deleted successfully.');
    //         }
    //         else{
    //             return $this->sendError('favourite item not found.'); 
    //         } 
    //     }
    //     else{
    //         return $this->sendError('product not found.'); 
    //     }
    // }

    // --------- using base controller ----finish-------



    public function getFavouriteList(Request $request)
	{
	    $result  = array();
		// $getresult  = Favourites::with('user','product')->where('user_id', '=' ,$request->user_id)->where('product_id', '=' ,$request->product_id)->get();
		$getresult  = Favourites::with('product')->where('user_id', '=' ,$request->user_id)->get();

        if(!empty($getresult->count() > 0)){
            $json['status'] = 1;
            $json['message'] = 'Favourite list loaded successfully.';
            $json['favourite_list'] = $getresult;
        }
        else{
            $json['status'] = 0;
            $json['message'] = 'Favourite list not found.';
        }

 	    echo json_encode($json);
	}

    public function deleteFavouriteProdcut(Request $request)
    {
        $data = Favourites::find($request->fav_id);
        $recode_update = Favourites::where('fav_id', '=' ,$request->fav_id)->where('product_id', '=' ,$request->product_id)->get();
		// $recode_update  = Favourites::with('product')->where('product_id', '=' ,$request->product_id)->where('fav_id', '=' ,$request->fav_id)->get();
        // dd($recode_update);

        if(!empty($getresult->count() > 0)){
            if($data->status == 0)
            {
                // $recode_update->status  = trim($request->status);
                $recode_update->status  = '1';
                $recode_update->save();
                $json['status'] = 1;
                $json['message'] = 'Favourite prodcut deleted successfully';
            }
        }else{
                $json['status'] = 0;
                $json['message'] = 'Product not found.';
            }
		echo json_encode($json);
    }

}
