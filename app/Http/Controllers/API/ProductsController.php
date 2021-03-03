<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\Product;
use App\Models\Category;
use App\Models\Sub_Category;
use App\Models\product_images;
use Validator;
use Illuminate\Support\Facades\Storage;

class ProductsController extends BaseController
{
    // retrive product by category
    public function product_details(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input,[
            'cat_id' => 'required',
        ]);
        
        $cat = category::find($request->input('cat_id'));
        $product = Product::where('cat_id',$request->input('cat_id'))->get();

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors()); 
        }elseif(!empty($cat)){
            if(!empty($product->count() > 0)){
                return $this->sendResponse_product($product,'Product Details retrieved successfully.');
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
        $product = Product::with('images')->get();
        // $product = Product::get();
        if(!empty($product)){
            // foreach($product as $key=>$value){
                // $id= $value->id;
                // $images = product_images::with('products')->where('product_id',$id)->get();
                // $path = $images[0]->images;
                // if(!empty($images)) {
                //     Storage::url($path);
                // }
                return $this->sendResponse_product($product,'Product retrieved successfully.');
        }else{
            return $this->sendError('Product not found.'); 
        }
    }

    public function product_search(Request $request)
    {
        $data = Category::with('product')->where('cat_name', 'like', '%' . $request->cat_name . '%')->get();

        if (!empty($request->cat_name)) {
            if(!empty($data->count() > 0)){
                return $this->sendResponse_product($data,'Search Category get Successfully.');
                }
            else{
                return $this->sendError('Search Category Not Found.'); 
            }
        }

        if (!empty($request->product_name)) {
            $product = Product::with('category,images')->where('product_name', 'like', '%' . $request->product_name . '%')->get();
            if(!empty($product->count() > 0)){
                return $this->sendResponse_product($product,'Search Category get Successfully.');
            }
            else{
                return $this->sendError('Search Product Not Found.'); 
            }
        }
    }


    public function subcategory_product_details(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input,[
            'sub_cat_id' => 'required',
        ]);
        
        $cat = Sub_Category::find($request->input('sub_cat_id'));
        $product = Product::where('sub_cat_id',$request->input('sub_cat_id'))->get();

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors()); 
        }elseif(!empty($cat)){
            if(!empty($product->count() > 0)){
                return $this->sendResponse_product($product,'Product Details retrieved successfully.');
            }else{
                    return $this->sendError('Product item not found.'); 
            }   
            }
        else{
            return $this->sendError('SubCategory not found.'); 
        }
    }


    //-------- other way ------------------

    public function getIamgeList(Request $request)
	{
	    $result  = array();
		$getresult  = product_images::where('product_id', '=' ,$request->product_id)->get();

        if(!empty($getresult->count() > 0)){
            $json['status'] = 1;
            $json['message'] = 'Image list loaded successfully.';
            $json['image_list'] = $getresult;
        }
        else{
            $json['status'] = 0;
            $json['message'] = 'Image list not found.';
        }

 	    echo json_encode($json);
	}

    
}
