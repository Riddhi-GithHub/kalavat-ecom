<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\Product;
use App\Models\Category;
use App\Models\Sub_Category;
use App\Models\product_images;
use App\Models\Size;
use App\Models\Brand;
use App\Models\Color;
use App\Models\Favourites;
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
        // $product = Product::where('cat_id',$request->input('cat_id'))->get();
        $product = Product::with('size','color')->where('cat_id',$request->input('cat_id'))->get();
        // dd($product);


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


    public function product_details_old(Request $request)
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
        // $product = Product::select('products.*');
        // $product = $product->join('favourites', 'products.product_id ', '=', 'favourites.fav_id');
        // $fav = Favourites::where('user_id','=',$request->user_id)->get();
        // dd($product);
        
            if(!empty($product)){
                        return $this->sendResponse_product($product,'Product retrieved successfully.');
                }else{
                    return $this->sendError('Product not found.'); 
                }
        // }
        // else{
        //     return $this->sendError('User not found.'); 
        // }
    }

    public function product_search(Request $request)
    {
        $result = array();
        $users = Product::select('products.*');
        $users = $users->join('categories', 'products.cat_id', '=', 'categories.id');

        // $product = Product::where([['product_name',$request['product_name']],])->get();
        // dd($product);
        $users = $users->where('categories.cat_name', 'like', '%' . $request->product_name . '%');
        dd($users);
        $new = $users->where('products.product_name', 'like', '%' . $request->product_name . '%');
        if(!empty($request->product_name)){
            // $new = $new->where('products.product_name', 'like', '%' . $request->product_name . '%');
            $data;
         }


        // if(!empty($request->cat_name)){
        //    $users = $users->where('categories.cat_name', 'like', '%' . $request->cat_name . '%');
        // }
        // if(!empty($request->product_name)){
        //    $users = $users->where('products.product_name', 'like', '%' . $request->product_name . '%');
        // }
        $users = $users->paginate(40);
     
        foreach ($users as $value) {

            $data['id']             = $value->id;
            $data['cat_name']      = !empty($value->category->cat_name) ? $value->category->cat_name : '';
            $data['product_name']  = !empty($value->product_name) ? $value->product_name : '';
            $result[] = $data;
        }
        $json['success'] = 1;
        $json['message'] = 'All loaded successfully.';
        $json['result'] = $result;
        
        echo json_encode($json);
    }

    public function product_search_vipul(Request $request)
    {
        $result = array();
        $users = Product::select('products.*');
        $users = $users->join('categories', 'products.cat_id', '=', 'categories.id');

        if(!empty($request->cat_name)){
           $users = $users->where('categories.cat_name', 'like', '%' . $request->cat_name . '%');
        }
        if(!empty($request->product_name)){
           $users = $users->where('products.product_name', 'like', '%' . $request->product_name . '%');
        }
        $users = $users->paginate(40);
     
        foreach ($users as $value) {

            $data['id']             = $value->id;
            $data['cat_name']      = !empty($value->category->cat_name) ? $value->category->cat_name : '';
            $data['product_name']  = !empty($value->product_name) ? $value->product_name : '';
            $result[] = $data;
        }
        $json['success'] = 1;
        $json['message'] = 'All loaded successfully.';
        $json['result'] = $result;
        
        echo json_encode($json);
    }



    public function product_search_riddhi(Request $request)
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
        else{
            return $this->sendError('Data Not Found.'); 
        }

        if (!empty($request->product_name)) {
            $product = Product::with('category')->where('product_name', 'like', '%' . $request->product_name . '%')->get();
            if(!empty($product->count() > 0)){
                return $this->sendResponse_product($product,'Search Category get Successfully.');
            }
            else{
                return $this->sendError('Search Product Not Found.'); 
            }
        }
        else{
            return $this->sendError('Data Not Found.'); 
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
        $result = array();
        $filter = Product::select('products.*');
        $filter = $filter->join('categories', 'products.cat_id', '=', 'categories.id');

        if(!empty($request->color)){
           $filter = $filter->where('products.color', 'like', '%' . $request->color . '%');
        }
        if(!empty($request->size)){
            $size = explode(",", $request->size);  
           $filter = $filter->whereIn('size',$size);
        }
        if(!empty($request->brand)){
            $brand = explode(",", $request->brand);  
            // $getbrand = Product::whereIn('brand',['naf','jack'])->get();
           $filter = $filter->whereIn('brand',$brand);
        }
        if(!empty($request->price)){
            $price = explode(",", $request->price);
            $min_price = implode(",", $price);
            $max_price = array_pop($price);
            // $pp = Product::whereBetween('price', [100,300])->get();
            // $getprice = Product::whereBetween('price', [$min_price,$max_price])->get();
           $filter = $filter->whereBetween('price', [$min_price,$max_price]);
        }

        $filter = $filter->paginate(40);
     
        foreach ($filter as $value) {

            $data['id']             = $value->id;
            $data['cat_name']      = !empty($value->category->cat_name) ? $value->category->cat_name : '';
            $data['product_name']  = !empty($value->product_name) ? $value->product_name : '';
            $data['price']  = !empty($value->price) ? $value->price : '';
            $data['img']  = !empty($value->img) ? $value->img : '';
            $data['color']  = !empty($value->color) ? $value->color : '';
            $data['size']  = !empty($value->size) ? $value->size : '';
            $data['brand']  = !empty($value->brand) ? $value->brand : '';
            $result[] = $data;
        }
        $json['success'] = 1;
        $json['message'] = 'All loaded successfully.';
        $json['result'] = $result;
        
        echo json_encode($json);
        
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


    public function filter_product_backup(Request $request)
    {
        $product = Product::get();

        # color data 
        $color = Product::where('color', 'like', '%' . $request->color . '%')->get();
          if (!empty($request->color)) {
            if(!empty($color->count() > 0)){
                return $this->sendResponse_product($color,'Search product get Successfully.');
                }
            else{
                return $this->sendError('Data Not Found.'); 
            }
        }

        # size
        $size = explode(",", $request->size);  
        // $getsize = Product::whereIn('size',['s','m'])->get();
        $getsize = Product::whereIn('size',$size)->get();
        if (!empty($request->size)) {
            if(!empty($getsize->count() > 0)){
                return $this->sendResponse_product($getsize,'Search product get Successfully.');
                }
            else{
                return $this->sendError('Data Not Found.'); 
            }
        }

         # Brand 
         $brand = explode(",", $request->brand);  
         // $getbrand = Product::whereIn('brand',['naf','jack'])->get();
         $getbrand = Product::whereIn('brand',$brand)->get();
         if (!empty($request->brand)) {
            if(!empty($getbrand->count() > 0)){
                return $this->sendResponse_product($getbrand,'Search product get Successfully.');
                }
            else{
                return $this->sendError('Data Not Found.'); 
            }
        }
         
        # price 
        $price = explode(",", $request->price);
        $min_price = implode(",", $price);
        $max_price = array_pop($price);
        // $pp = Product::whereBetween('price', [100,300])->get();
        $getprice = Product::whereBetween('price', [$min_price,$max_price])->get();
       
        if (!empty($request->price)) {
            if(!empty($getprice->count() > 0)){
                return $this->sendResponse_product($getprice,'Search product get Successfully.');
                }
            else{
                return $this->sendError('Data Not Found.'); 
            }
        }
    }

}
