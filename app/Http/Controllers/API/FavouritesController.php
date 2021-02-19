<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\Product;
use App\Models\category;
use App\Models\Favourites;
use Validator;

class FavouritesController extends BaseController
{
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

    public function delete_favourite(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input,[
            'fav_id' => 'required',
            'product_id' => 'required',
            ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }
        
        $product = Product::find($request->input('product_id'));
        $fav = Favourites::where('fav_id ',$request->fav_id )->where('product_id',$request->product_id)->get();
          
        if(!empty($product)){
            if($validator->fails()){
                return $this->sendError('Validation Error.', $validator->errors()); 
            }elseif(!empty($fav)){
                return $this->sendResponse($fav,'favourite product deleted successfully.');
            }
            else{
                return $this->sendError('favourite item not found.'); 
            } 
        }
        else{
            return $this->sendError('product not found.'); 
        }
    }

}
