<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\Product;
use App\Models\category;
use Validator;

class ProductsController extends BaseController
{
    // retrive product by category
    public function product_details(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'cat_id' => 'required',
        ]);

        $cat = category::find($request->input('cat_id'));
        // $product = Product::where('cat_id',$request->input('cat_id'))->get();
        $product = Product::where('cat_id',$input['cat_id'])->get();

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors()); 
        }elseif(!empty($cat)){
            if(!empty($product->count() > 0)){
                return $this->sendResponse($product,'Product Details retrieved successfully.');
            }else{
                    return $this->sendError('Product item not found.'); 
            }   
            }
        else{
            return $this->sendError('category not found.'); 
        }
    }

    // retrive all product
    public function product_list(Request $request)
    {
        $product = Product::get();
        if(!empty($product)){
            return $this->sendResponse($product,'Product retrieved successfully.');
        }else{
            return $this->sendError('Product not found.'); 
        }
    }

    public function product_search(Request $request)
    {
        $input = $request->all();
        $data = $request->get('data');

        $cat = category::with('product')
        // ->where('cat_name', 'like', "%{$data}%")
        ->where('cat_name',$request->input('cat_name'))
        ->get();

        $product = Product::with('category')
        // ->where('product_name', 'like', "%{$data}%")
        ->where('product_name',$request->input('product_name'))
        ->get();

        // $cat = category::where('cat_name',$request->input('cat_name'));
        // $product = Product::where('product_name',$input['product_name'])->get();
        // dd($product);

        if(!empty($cat->count() > 0)){
            return $this->sendResponse($cat,'search category item get successfully.');
        }elseif(!empty($product->count() > 0)){
            return $this->sendResponse($product,'search product item get successfully.');
        }
            return $this->sendError('search item not found.'); 
    }
    
}
