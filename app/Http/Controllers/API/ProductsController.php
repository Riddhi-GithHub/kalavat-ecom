<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\Product;
use App\Models\Category;
use App\Models\Sub_Category;
use App\Models\product_images;
use Validator;
use DB;
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

    public function filter_product(Request $request)
    {
        $product = Product::get();

          # all data 
          $data['color'] = Product::where('color', 'like', '%' . $request->color . '%')->get();

          $size = explode(",", $request->size);  
          $data['size'] = Product::whereIn('size',$size)->get();

          $price = explode(",", $request->price);
          $min_price = implode(",", $price);
          $max_price = array_pop($price);
          // $pp = Product::whereBetween('price', [100,300])->get();
          $data['price'] = Product::whereBetween('price', [$min_price,$max_price])->get();

          dd($data);




        # color
          $color = Product::where('color', 'like', '%' . $request->color . '%')->get();
          if(!empty($product)){
             if (!empty($color->count() > 0)) {
                 return $this->sendResponse_product($color,'Filter Color Product retrieved successfully.');
             }
             else{
                 return $this->sendError('Filter Color Product not found.'); 
             }
         }
         else{
             return $this->sendError('Product not found.'); 
         }
 


        # size
        $size = explode(",", $request->size);  
        // $getsize = Product::whereIn('size',['s','m'])->get();
        $getsize = Product::whereIn('size',$size)->get();

        if(!empty($product)){
            if (!empty($getsize->count() > 0)) {
                return $this->sendResponse_product($getsize,'Filter size Product retrieved successfully.');
            }
            else{
                return $this->sendError('Filter Color Product not found.'); 
            }
        }
        else{
            return $this->sendError('Product not found.'); 
        }

       
        # price 
        $price = explode(",", $request->price);
        $min_price = implode(",", $price);
        $max_price = array_pop($price);
        // $pp = Product::whereBetween('price', [100,300])->get();
        $getprice = Product::whereBetween('price', [$min_price,$max_price])->get();


        # Brand 
        $brand = explode(",", $request->brand);  
        // $getbrand = Product::whereIn('brand',['naf','jack'])->get();
        $getbrand = Product::whereIn('brand',$brand)->get();

       
       
        









        $size = Product::where('size', 'like', '%' . $request->size . '%')
        ->where('color', 'like', '%' . $request->color . '%')
        ->get();
        
        $product = Product::get();
        $size = Product::where('size', 'like', '%' . $request->size . '%')->get();
        
        if(!empty($product)){
            if (!empty($size->count() > 0)) {
                return $this->sendResponse_product($size,'Filter size Product retrieved successfully.');
            }
            else{
                return $this->sendError('Filter Color Product not found.'); 
            }
        }
        else{
            return $this->sendError('Product not found.'); 
        }

        // color filter
        $color = Product::where('color', 'like', '%' . $request->color . '%')->get();
       
        $price = $request->price;
        $min_price = Product::where('price', '<=', $price)->get();
        $max_price = Product::where('price', '>=', $price)->get();
        // dd(($min_price));

        // min price filter
        if(!empty($product)){
            if (!empty($min_price->count() > 0)) {
                return $this->sendResponse_product($min_price,'Min Price Product retrieved successfully.');
            }
            else{
                return $this->sendError('Min or Max Price Product not found.'); 
            }
        }
        else{
            return $this->sendError('Product not found.'); 
        }

        // max price filter
        // if(!empty($product)){
        //     if (!empty($max_price->count() > 0)) {
        //         return $this->sendResponse_product($max_price,'Max Price Product retrieved successfully.');
        //     }
        //     else{
        //         return $this->sendError('Min or Max Price Product not found.'); 
        //     }
        // }
        // else{
        //     return $this->sendError('Product not found.'); 
        // }
           
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
