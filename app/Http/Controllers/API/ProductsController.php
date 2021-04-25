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
use App\Models\Rating;
use App\Models\Cart;
use App\Models\Favourites;
use App\Models\ProductDetails;
use App\Models\Sale;
use App\Models\Catalog;
use App\Models\Catalog_rating;
use App\User;
use Validator;
use DB;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class ProductsController extends BaseController
{
    # share product or catalog
    public function app_share_item(Request $request)
    {
        if($request->product_id || $request->catalog_id)
        {
            $product_data = Product::with('images')->find($request->product_id);
            $catalog_data = Catalog::find($request->catalog_id);

            if(!empty($product_data))
            {
                $pid = $product_data->id;
                $rates = DB::table('ratings')
                ->where('product_id', $pid)
                ->avg('rating_avg');

                $num = (double) $rates;
                if(!empty($num)){
                    $product_data['rating_count']=$num;
                }else{
                    $product_data['rating_count']=0;
                }
                return $this->sendResponse_product($product_data,'Product share successfully.');
            }elseif(!empty($catalog_data)){

                        # catalog rating
                        $cid = $catalog_data->id;
                        $rates = DB::table('catalog_rating')
                        ->where('rating_catalog_id', $cid)
                        ->avg('catalog_rating_avg');

                        $num = (double) $rates;
                        if(!empty($num)){
                            $catalog_data['catalog_rating_count']=$num;
                        }else{
                            $catalog_data['catalog_rating_count']=0;
                        }
                        # catalog favourite
                        $fid = $catalog_data->id;
                        $getresult  = Favourites::
                            where('user_id', '=' ,$request->user_id)
                            ->where('catalog_id', '=' ,$fid)->first();

                            if(!empty($getresult)){
                                $is_fav=$getresult->status;
                                $catalog_data['catalog_is_fav']=$is_fav;
                            }else{
                                $catalog_data['catalog_is_fav']=0;
                            }

                        $product_id = $catalog_data->product_id;
                        $array_product_id = explode(',', $product_id);
                        $product = Product::with('images')->whereIn('id',$array_product_id)->get();
                        
                        $rating_count ="";
                        foreach($product as $p){
                            $pid = $p->id;
                                $rates = DB::table('ratings')
                                ->where('product_id', $pid)
                                ->avg('rating_avg');
            
                                $num = (double) $rates;
                                if(!empty($num)){
                                    $p['rating_count']=$num;
                                }else{
                                    $p['rating_count']=0;
                                }
                        }

                        $catalog_data['product_list'] = $product;
                // return $this->sendResponse_product($catalog_data,'Catalog share successfully.');
                $json['status'] = 1;
                $json['message'] = 'Catalog share successfully.';
                $json['catalog_list'] = $catalog_data;
            }
            else{
                return $this->sendError('Data not found.'); 
            }
        }
        else{
            return $this->sendError('Fill Required data!'); 
        }
        echo json_encode($json);
    }

    public function product_details(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input,[
            // 'cat_id' => 'required',
            'sub_category_id' => 'required',
            'user_id' => 'required',
        ]);
            $subcat = Sub_Category::find($request->input('sub_category_id'));
            $sorting  = Catalog::where('sub_category_id',$request->sub_category_id);
            // $getalldata = $sorting->get();
            $getalldata = $sorting->orderBy('id','desc')->paginate(20);
            $sorting_data = $request->sorting_data; 

        // start filter
            if(!empty($request->size)){
                $size = explode(",", $request->size);  
                $getalldata = $getalldata->whereIn('catalog_size',$size);
            }
            if(!empty($request->brand)){
                $brand = explode(",", $request->brand);  
                // $getbrand = Product::whereIn('brand',['naf','jack'])->get();
                $getalldata = $getalldata->whereIn('catalog_brand',$brand);
            }
            if(!empty($request->price)){
                $price = explode(",", $request->price);
                $min_price = implode(",", $price);
                $max_price = array_pop($price);
                // $pp = Product::whereBetween('price', [100,300])->get();
                // $getprice = Product::whereBetween('price', [$min_price,$max_price])->get();
                $getalldata = $getalldata->whereBetween('catalog_amount', [$min_price,$max_price]);
            }
        // end filter

        // sorting start
            elseif($sorting_data == 1){
                // $sorting = $sorting->orderBy('id','desc')->get();
                $sorting = $sorting->orderBy('id','desc')->paginate(20);
                foreach($sorting as $result){
                      # catalog rating
                      $cid = $result->id;
                      $rates = DB::table('catalog_rating')
                      ->where('rating_catalog_id', $cid)
                      ->avg('catalog_rating_avg');
          
                        $num = (double) $rates;
                        if(!empty($num)){
                            $result['catalog_rating_count']=$num;
                        }else{
                            $result['catalog_rating_count']=0;
                        }
                      # catalog favourite
                      $fid = $result->id;
                      $getresult  = Favourites::
                          where('user_id', '=' ,$request->user_id)
                          ->where('catalog_id', '=' ,$fid)->first();
  
                        if(!empty($getresult)){
                            $is_fav=$getresult->status;
                            $result['catalog_is_fav']=$is_fav;
                        }else{
                            $result['catalog_is_fav']=0;
                        }

                    #product data 
                    $product_id = $result->product_id;
                    $array_product_id = explode(',', $product_id);
                    $product = Product::with('images')->whereIn('id',$array_product_id)->get();
    
                    $is_fav="";
                    foreach($product as $p){
                        $pid = $p->id;
                            $getresult  = Favourites::
                                where('user_id', '=' ,$request->user_id)
                                ->where('product_id', '=' ,$pid)->first();
                                if(!empty($getresult)){
                                    $is_fav=$getresult->status;
                                    //dd($is_fav);
                                    $p['is_fav']=$is_fav;
                                    //dd($p);
                                }else{
                                    $p['is_fav']=0;
                                }
                    }
    
                    $rating_count ="";
                    foreach($product as $p){
                        $pid = $p->id;
                            $rates = DB::table('ratings')
                            ->where('product_id', $pid)
                            ->avg('rating_avg');
        
                            $num = (double) $rates;
                            if(!empty($num)){
                                $p['rating_count']=$num;
                            }else{
                                $p['rating_count']=0;
                            }
                    }
                    
                    $result['product_list'] = $product;
                }
                return $this->sendResponse_catalog($sorting,'Newest Product retrieved successfully.'); 
            }
            elseif($sorting_data == 2){
                // $sorting = $sorting->orderBy('catalog_amount')->get();
                $sorting = $sorting->orderBy('catalog_amount')->paginate(20);
                // $sorting = $sorting->orderBy('catalog_amount')->orderBy('id','desc')->paginate(20);
                foreach($sorting as $result){

                      # catalog rating
                      $cid = $result->id;
                      $rates = DB::table('catalog_rating')
                      ->where('rating_catalog_id', $cid)
                      ->avg('catalog_rating_avg');
          
                        $num = (double) $rates;
                        if(!empty($num)){
                            $result['catalog_rating_count']=$num;
                        }else{
                            $result['catalog_rating_count']=0;
                        }
                      # catalog favourite
                      $fid = $result->id;
                      $getresult  = Favourites::
                          where('user_id', '=' ,$request->user_id)
                          ->where('catalog_id', '=' ,$fid)->first();
  
                        if(!empty($getresult)){
                            $is_fav=$getresult->status;
                            $result['catalog_is_fav']=$is_fav;
                        }else{
                            $result['catalog_is_fav']=0;
                        }   
                    # product data 
                    $product_id = $result->product_id;
                    $array_product_id = explode(',', $product_id);
                    $product = Product::with('images')->whereIn('id',$array_product_id)->get();
    
                    $is_fav="";
                    foreach($product as $p){
                        $pid = $p->id;
                            $getresult  = Favourites::
                                where('user_id', '=' ,$request->user_id)
                                ->where('product_id', '=' ,$pid)->first();
                                if(!empty($getresult)){
                                    $is_fav=$getresult->status;
                                    //dd($is_fav);
                                    $p['is_fav']=$is_fav;
                                    //dd($p);
                                }else{
                                    $p['is_fav']=0;
                                }
                    }
    
                    $rating_count ="";
                    foreach($product as $p){
                        $pid = $p->id;
                            $rates = DB::table('ratings')
                            ->where('product_id', $pid)
                            ->avg('rating_avg');
        
                            $num = (double) $rates;
                            if(!empty($num)){
                                $p['rating_count']=$num;
                            }else{
                                $p['rating_count']=0;
                            }
                    }
                    
                    $result['product_list'] = $product;
                }
                
                return $this->sendResponse_catalog($sorting,'Lowest Price wise Product retrieved successfully.'); 
            }
            elseif($sorting_data == 3){
                // $sorting = $sorting->orderBy('catalog_amount','desc')->get();
                $sorting = $sorting->orderBy('catalog_amount','desc')->paginate(20);
                // $sorting = $sorting->orderBy('catalog_amount','desc')->orderBy('id','desc')->paginate(20);
                foreach($sorting as $result){
                     # catalog rating
                     $cid = $result->id;
                     $rates = DB::table('catalog_rating')
                     ->where('rating_catalog_id', $cid)
                     ->avg('catalog_rating_avg');
         
                       $num = (double) $rates;
                       if(!empty($num)){
                           $result['catalog_rating_count']=$num;
                       }else{
                           $result['catalog_rating_count']=0;
                       }
                   # catalog favourite
                     $fid = $result->id;
                     $getresult  = Favourites::
                         where('user_id', '=' ,$request->user_id)
                         ->where('catalog_id', '=' ,$fid)->first();
 
                       if(!empty($getresult)){
                           $is_fav=$getresult->status;
                           $result['catalog_is_fav']=$is_fav;
                       }else{
                           $result['catalog_is_fav']=0;
                       }  

                    # product data 
                    $product_id = $result->product_id;
                    $array_product_id = explode(',', $product_id);
                    $product = Product::with('images')->whereIn('id',$array_product_id)->get();
    
                    $rating_count ="";
                    foreach($product as $p){
                        $pid = $p->id;
                            $rates = DB::table('ratings')
                            ->where('product_id', $pid)
                            ->avg('rating_avg');
        
                            $num = (double) $rates;
                            if(!empty($num)){
                                $p['rating_count']=$num;
                            }else{
                                $p['rating_count']=0;
                            }
                    }
                    
                    $result['product_list'] = $product;
                }
                return $this->sendResponse_catalog($sorting,'Highest Price wise Product retrieved successfully.'); 
            }
            elseif($sorting_data == 4){
                //$rates = Rating::orderBy('rating_avg','desc')->get();
                $rates = Catalog_rating::orderBy('catalog_rating_avg','desc')->get();
                foreach($rates as $r){
                    $p_id = $r->rating_catalog_id ;
                // dd($p_id);
                $sorting = $sorting->whereIn('id',$p_id)->orderBy('id','desc')->paginate(20);
                 # product data 
                 $product_id = $result->product_id;
                 $array_product_id = explode(',', $product_id);
                 $product = Product::with('images')->whereIn('id',$array_product_id)->get();

                $rating_count ="";
                foreach($sorting as $p){
                    $pid = $p->id;
                        $rates = DB::table('catalog_rating')
                        ->where('rating_catalog_id', $pid)
                        ->avg('catalog_rating_avg');
    
                        $num = (double) $rates;
                        if(!empty($num)){
                            $p['rating_count']=$num;
                        }else{
                            $p['rating_count']=0;
                        }
                }
                $is_fav="";
                foreach($sorting as $p){
                    $pid = $p->id;
                        $getresult  = Favourites::
                            where('user_id', '=' ,$request->user_id)
                            ->where('catalog_id', '=' ,$pid)->first();
                            if(!empty($getresult)){
                                $is_fav=$getresult->status;
                                //dd($is_fav);
                                $p['is_fav']=$is_fav;
                                //dd($p);
                            }else{
                                $p['is_fav']=0;
                            }
                }
                $r['product_list'] = $product;
            }

                return $this->sendResponse_product($sorting,'Product retrieved successfully.'); 
    
                
                return $this->sendResponse_catalog($getalldata,'No Rating.'); 
            }
            elseif($sorting_data == 5){
                $cart = Cart::get();
                foreach($cart as $c){
                    $c_p_id[] = $c->product_id;
                }
                $fav = Favourites::get();
                foreach($fav as $f){
                    $f_p_id[] = $f->product_id;
                }
                // dd($c_p_id);
                $i['c'] = $c_p_id;
                $i['f'] = $f_p_id;
                
                // $sorting = $sorting->whereIn('id',$c_p_id)
                // ->orwhereIn('id',$f_p_id)->where('sub_cat_id',$request->sub_cat_id)->get();
                // $sorting = $sorting->get();
                $is_fav="";
                foreach($sorting as $p){
                $pid = $p->id;
                    $getresult  = Favourites::
                        where('user_id', '=' ,$request->user_id)
                        ->where('product_id', '=' ,$pid)->first();
                        if(!empty($getresult)){
                            $is_fav=$getresult->status;
                            //dd($is_fav);
                            $p['is_fav']=$is_fav;
                            //dd($p);
                        }else{
                            $p['is_fav']=0;
                        }
                }
                $rating_count ="";
                foreach($sorting as $p){
                    $pid = $p->id;
                        $rates = DB::table('ratings')
                        ->where('product_id', $pid)
                        ->avg('rating_avg');

                        $num = (double) $rates;
                        if(!empty($num)){
                            $p['rating_count']=$num;
                        }else{
                            $p['rating_count']=0;
                        }
                }
                return $this->sendResponse_catalog($getalldata,'No cart,No favourite.'); 
            }

        // sorting end 
        // dd($getalldata);
        // dd(!empty($getalldata->count() > 0));

        // $getalldata = $sorting->orderBy('id','desc')->paginate(20);
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors()); 
        }elseif(!empty($subcat)){
            if(!empty($getalldata->count() > 0)){
                $getalldata = $sorting->orderBy('id','desc')->paginate(20);
                foreach($getalldata as $result){
                      # catalog rating
                      $cid = $result->id;
                      $rates = DB::table('catalog_rating')
                      ->where('rating_catalog_id', $cid)
                      ->avg('catalog_rating_avg');
          
                        $num = (double) $rates;
                        if(!empty($num)){
                            $result['catalog_rating_count']=$num;
                        }else{
                            $result['catalog_rating_count']=0;
                        }
                    # catalog favourite
                      $fid = $result->id;
                      $getresult  = Favourites::
                          where('user_id', '=' ,$request->user_id)
                          ->where('catalog_id', '=' ,$fid)->first();
  
                        if(!empty($getresult)){
                            $is_fav=$getresult->status;
                            $result['catalog_is_fav']=$is_fav;
                        }else{
                            $result['catalog_is_fav']=0;
                        }  
 
                     # product data 

                    $product_id = $result->product_id;
                    $array_product_id = explode(',', $product_id);
                    $product = Product::with('images')->whereIn('id',$array_product_id)->get();
    
                    $is_fav="";
                    foreach($product as $p){
                        $pid = $p->id;
                            $getresult  = Favourites::
                                where('user_id', '=' ,$request->user_id)
                                ->where('product_id', '=' ,$pid)->first();
                                if(!empty($getresult)){
                                    $is_fav=$getresult->status;
                                    //dd($is_fav);
                                    $p['is_fav']=$is_fav;
                                    //dd($p);
                                }else{
                                    $p['is_fav']=0;
                                }
                    }
    
                    $rating_count ="";
                    foreach($product as $p){
                        $pid = $p->id;
                            $rates = DB::table('ratings')
                            ->where('product_id', $pid)
                            ->avg('rating_avg');
        
                            $num = (double) $rates;
                            if(!empty($num)){
                                $p['rating_count']=$num;
                            }else{
                                $p['rating_count']=0;
                            }
                    }
                    
                    $result['product_list'] = $product;
                }
                return $this->sendResponse_catalog($getalldata,'Product Details retrieved successfully.');
            }else{
                    return $this->sendError('Product item not found.'); 
                }   
            } 
        else{
            return $this->sendError('Subcategory not found.'); 
        }
    }

    // retrive product by subcategory
    public function product_details__(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input,[
            // 'cat_id' => 'required',
            'sub_cat_id' => 'required',
            'user_id' => 'required',
        ]);
        
       $cat = category::find($request->input('cat_id'));
       $subcat = Sub_Category::find($request->input('sub_cat_id'));
       $product = Product::with('size','color','images')->where('sub_cat_id',$request->input('sub_cat_id'))->get();
      //$product = Product::with('size','color','images')->where('sub_cat_id',$request->input('sub_cat_id'))->orderBy('id', 'desc')->paginate(40);
        
       $filter = Product::with('images','size','color')
        ->where('sub_cat_id',$request->sub_cat_id)->orderBy('id', 'desc')->paginate(2);
        //    ->where('sub_cat_id',$request->sub_cat_id)->get();
       
       $sorting = Product::with('images','size','color')->where('sub_cat_id',$request->sub_cat_id);
       $sorting_all = $sorting->get();
       $sorting_data = $request->sorting_data; 

       // $product = Product::where('cat_id',$request->input('cat_id'))->get();
        // $product = Product::with('size','color','images')->where('cat_id',$request->input('cat_id'))->get();
        // dd($product);
        $is_fav="";
        $user = Favourites::where('user_id', '=' ,$request->user_id)->get();
            foreach($filter as $p){
            $pid = $p->id;
                $getresult  = Favourites::
                    where('user_id', '=' ,$request->user_id)
                    ->where('product_id', '=' ,$pid)->first();
                    if(!empty($getresult)){
                        $is_fav=$getresult->status;
                        //dd($is_fav);
                        $p['is_fav']=$is_fav;
                        //dd($p);
                    }else{
                        $p['is_fav']=0;
                    }
            }

        $rating_count ="";
            foreach($filter as $p){
                $pid = $p->id;
                $rates = DB::table('ratings')
                ->where('product_id', $pid)
                ->avg('rating_avg');
                $num = (double) $rates;
                    if(!empty($num)){
                        $p['rating_count']=$num;
                    }else{
                        $p['rating_count']=0;
                    }
            }

           

            // if(!empty($request->size)){
                // foreach($filter as $value){
                    // dd($value);
                    // $sz = $value->size;
                    // dd($sz);
                // }
                    // $size = explode(",", $request->size);  
                    // $filter = $sz->whereIn('size',$size);
                    // $filter = $filter->size->whereIn('size',$size);
                    // dd($filter);
            // }
            // dd($ss);

        
        // filter start
            if(!empty($request->color)){
                $filter = $filter->where('colorrr', $request->color);
                // return $this->sendResponse_product($product,'Product retrieved successfully.');
            }
            if(!empty($request->size)){
                $size = explode(",", $request->size);  
                $filter = $filter->whereIn('sizess',$size);
            }
            if(!empty($request->brand)){
                $brand = explode(",", $request->brand);  
                // $getbrand = Product::whereIn('brand',['naf','jack'])->get();
                $filter = $filter->whereIn('branddd',$brand);
            }
            if(!empty($request->price)){
                $price = explode(",", $request->price);
                $min_price = implode(",", $price);
                $max_price = array_pop($price);
                // $pp = Product::whereBetween('price', [100,300])->get();
                // $getprice = Product::whereBetween('price', [$min_price,$max_price])->get();
                $filter = $filter->whereBetween('price', [$min_price,$max_price]);
            }
        //end  filter

        // sorting start
        
        elseif($sorting_data == 1){
            $sorting = $sorting->orderBy('id','desc')->get();
            $is_fav="";
            foreach($sorting as $p){
            $pid = $p->id;
                $getresult  = Favourites::
                    where('user_id', '=' ,$request->user_id)
                    ->where('product_id', '=' ,$pid)->first();
                    if(!empty($getresult)){
                        $is_fav=$getresult->status;
                        //dd($is_fav);
                        $p['is_fav']=$is_fav;
                        //dd($p);
                    }else{
                        $p['is_fav']=0;
                    }
            }

            $rating_count ="";
            foreach($sorting as $p){
                $pid = $p->id;
                    $rates = DB::table('ratings')
                    ->where('product_id', $pid)
                    ->avg('rating_avg');

                    $num = (double) $rates;
                    if(!empty($num)){
                        $p['rating_count']=$num;
                    }else{
                        $p['rating_count']=0;
                    }
            }
            return $this->sendResponse_product($sorting,'Product retrieved successfully.'); 
        }
        elseif($sorting_data == 2){
            $sorting = $sorting->orderBy('price')->get();
           
            $is_fav="";
            foreach($sorting as $p){
            $pid = $p->id;
                $getresult  = Favourites::
                    where('user_id', '=' ,$request->user_id)
                    ->where('product_id', '=' ,$pid)->first();
                    if(!empty($getresult)){
                        $is_fav=$getresult->status;
                        //dd($is_fav);
                        $p['is_fav']=$is_fav;
                        //dd($p);
                    }else{
                        $p['is_fav']=0;
                    }
            }

            $rating_count ="";
            foreach($sorting as $p){
                $pid = $p->id;
                    $rates = DB::table('ratings')
                    ->where('product_id', $pid)
                    ->avg('rating_avg');

                    $num = (double) $rates;
                    if(!empty($num)){
                        $p['rating_count']=$num;
                    }else{
                        $p['rating_count']=0;
                    }
            }
            return $this->sendResponse_product($sorting,'Product retrieved successfully.'); 
        }
        elseif($sorting_data == 3){
            $sorting = $sorting->orderBy('price','desc')->get();
           
            $is_fav="";
            foreach($sorting as $p){
            $pid = $p->id;
                $getresult  = Favourites::
                    where('user_id', '=' ,$request->user_id)
                    ->where('product_id', '=' ,$pid)->first();
                    if(!empty($getresult)){
                        $is_fav=$getresult->status;
                        //dd($is_fav);
                        $p['is_fav']=$is_fav;
                        //dd($p);
                    }else{
                        $p['is_fav']=0;
                    }
            }

            $rating_count ="";
            foreach($sorting as $p){
                $pid = $p->id;
                    $rates = DB::table('ratings')
                    ->where('product_id', $pid)
                    ->avg('rating_avg');

                    $num = (double) $rates;
                    if(!empty($num)){
                        $p['rating_count']=$num;
                    }else{
                        $p['rating_count']=0;
                    }
            }
            return $this->sendResponse_product($sorting,'Product retrieved successfully.'); 
        }
        elseif($sorting_data == 4){
            $rates = Rating::orderBy('rating_avg','desc')->get();
            foreach($rates as $r){
                $p_id[] = $r->product_id;
            }
            // dd($p_id);
            $sorting = $sorting->whereIn('id',$p_id)->orderBy('id','desc')->get();

            $is_fav="";
            foreach($sorting as $p){
            $pid = $p->id;
                $getresult  = Favourites::
                    where('user_id', '=' ,$request->user_id)
                    ->where('product_id', '=' ,$pid)->first();
                    if(!empty($getresult)){
                        $is_fav=$getresult->status;
                        //dd($is_fav);
                        $p['is_fav']=$is_fav;
                        //dd($p);
                    }else{
                        $p['is_fav']=0;
                    }
            }
            $rating_count ="";
            foreach($sorting as $p){
                $pid = $p->id;
                    $rates = DB::table('ratings')
                    ->where('product_id', $pid)
                    ->avg('rating_avg');

                    $num = (double) $rates;
                    if(!empty($num)){
                        $p['rating_count']=$num;
                    }else{
                        $p['rating_count']=0;
                    }
            }
            return $this->sendResponse_product($sorting,'Product retrieved successfully.'); 
        }
        elseif($sorting_data == 5){
            $cart = Cart::get();
            foreach($cart as $c){
                $c_p_id[] = $c->product_id;
            }
            $fav = Favourites::get();
            foreach($fav as $f){
                $f_p_id[] = $f->product_id;
            }
            // dd($c_p_id);
            $i['c'] = $c_p_id;
            $i['f'] = $f_p_id;
            
            $sorting = $sorting->whereIn('id',$c_p_id)
            ->orwhereIn('id',$f_p_id)->where('sub_cat_id',$request->sub_cat_id)->get();
            // $sorting = $sorting->get();
            $is_fav="";
            foreach($sorting as $p){
            $pid = $p->id;
                $getresult  = Favourites::
                    where('user_id', '=' ,$request->user_id)
                    ->where('product_id', '=' ,$pid)->first();
                    if(!empty($getresult)){
                        $is_fav=$getresult->status;
                        //dd($is_fav);
                        $p['is_fav']=$is_fav;
                        //dd($p);
                    }else{
                        $p['is_fav']=0;
                    }
            }
            $rating_count ="";
            foreach($sorting as $p){
                $pid = $p->id;
                    $rates = DB::table('ratings')
                    ->where('product_id', $pid)
                    ->avg('rating_avg');

                    $num = (double) $rates;
                    if(!empty($num)){
                        $p['rating_count']=$num;
                    }else{
                        $p['rating_count']=0;
                    }
            }
            return $this->sendResponse_product($sorting,'Product retrieved successfully.'); 
        }
        // sorting end 

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors()); 
        }elseif(!empty($subcat)){
            if(!empty($filter->count() > 0)){
                return $this->sendResponse_product($filter,'Product Details retrieved successfully.');
            }else{
                    return $this->sendError('Product item not found.'); 
                }   
            }
        else{
            return $this->sendError('Subcategory not found.'); 
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

    // retrive all product more information
    public function product_more_information(Request $request)
    {
        if($request->product_id && $request->user_id){
          $product = Product::with('images','size','color','manufacturing','productdetails')
          ->where('id',$request->product_id)->get();

          $user = Favourites::where('user_id', '=' ,$request->user_id)->get();
            
          $is_fav="";
            foreach($product as $p){
                    //   dd($request->product_id);
                  $getresult  = Favourites::
                      where('user_id', '=' ,$request->user_id)
                      ->where('product_id', '=' ,$request->product_id)->first();
                      if(!empty($getresult)){
                          $is_fav=$getresult->status;
                          //dd($is_fav);
                          $p['is_fav']=$is_fav;
                          //dd($p);
                      }else{
                          $p['is_fav']=0;
                      }
            }

        $rating_count ="";
        foreach($product as $p){
            $pid = $p->id;
                $rates = DB::table('ratings')
                ->where('product_id', $pid)
                ->avg('rating_avg');

                $num = (double) $rates;
                    if(!empty($num)){
                        $p['rating_count']=$num;
                    }else{
                        $p['rating_count']=0;
                    }
        }

          if(!empty($product)){
                      return $this->sendResponse_product($product,'Product retrieved successfully.');
          }else{
              return $this->sendError('Product not found.'); 
          }
        }
        else{
            return $this->sendError('Fill Required data!'); 
        }
    }

    // retrive catalog wise product
    public function sale_product_list(Request $request)
    {
        if($request->user_id){
        // $getresult  = Catalog::get();
        $user = User::find($request->user_id);
        if(!empty($user)){
            $getalldata  = Catalog::orderBy('id','desc')->paginate(20);
        
            if(!empty($getalldata)){
                foreach($getalldata as $result){
                    # catalog rating
                    $cid = $result->id;
                    $rates = DB::table('catalog_rating')
                    ->where('rating_catalog_id', $cid)
                    ->avg('catalog_rating_avg');
        
                    $num = (double) $rates;
                    if(!empty($num)){
                        $result['catalog_rating_count']=$num;
                    }else{
                        $result['catalog_rating_count']=0;
                    }
                    # catalog favourite
                    $fid = $result->id;
                    $getresult  = Favourites::
                        where('user_id', '=' ,$request->user_id)
                        ->where('catalog_id', '=' ,$fid)->first();

                        if(!empty($getresult)){
                            $is_fav=$getresult->status;
                            $result['catalog_is_fav']=$is_fav;
                        }else{
                            $result['catalog_is_fav']=0;
                        }

                    # product data 
                    $product_id = $result->product_id;
                    $array_product_id = explode(',', $product_id);
                    $product = Product::with('images')->whereIn('id',$array_product_id)->get();

                    // $is_fav="";
                    // foreach($product as $p){
                    //     $pid = $p->id;
                    //         $getresult  = Favourites::
                    //             where('user_id', '=' ,$request->user_id)
                    //             ->where('product_id', '=' ,$pid)->first();
                    //             if(!empty($getresult)){
                    //                 $is_fav=$getresult->status;
                    //                 //dd($is_fav);
                    //                 $p['is_fav']=$is_fav;
                    //                 //dd($p);
                    //             }else{
                    //                 $p['is_fav']=0;
                    //             }
                    // }

                    $rating_count ="";
                    foreach($product as $p){
                        $pid = $p->id;
                            $rates = DB::table('ratings')
                            ->where('product_id', $pid)
                            ->avg('rating_avg');
        
                            $num = (double) $rates;
                            if(!empty($num)){
                                $p['rating_count']=$num;
                            }else{
                                $p['rating_count']=0;
                            }
                    }
                    
                    $result['product_list'] = $product;
                }
            $json['status'] = 1;
            $json['message'] = 'Catalog list Loaded Successfully.';
            $json['catalog_list'] = $getalldata;
            }
            else{
                $json['status'] = 0;
                $json['message'] = 'Data not Found.';
            }
        }
        else{
			$json['status'] = 0;
			$json['message'] = 'User not Found.';
		}
        }
        else{
			$json['status'] = 0;
			$json['message'] = 'Fill required Data.';
		}
        echo json_encode($json);
    }

    // retrive prodcut catalog wise 
    public function sale_product_details(Request $request)
    {
        if($request->user_id && $request->sale_id){
            $getresult  = Catalog::with('product')->where('id',$request->sale_id)->first();
            // dd($getresult->product_id);

            $array_product_id = explode(',', $getresult->product_id);
            // dd($array_product_id);
            $product = Product::with('images')->whereIn('id',$array_product_id)->get();

            $is_fav="";
            foreach($product as $p){
            $pid = $p->id;
                $getresult  = Favourites::
                    where('user_id', '=' ,$request->user_id)
                    ->where('product_id', '=' ,$pid)->first();
                    if(!empty($getresult)){
                        $is_fav=$getresult->status;
                        //dd($is_fav);
                        $p['is_fav']=$is_fav;
                        //dd($p);
                    }else{
                        $p['is_fav']=0;
                    }
            }

            $rating_count ="";
            foreach($product as $p){
                $pid = $p->id;
                    $rates = DB::table('ratings')
                    ->where('product_id', $pid)
                    ->avg('rating_avg');

                    $num = (double) $rates;
                    if(!empty($num)){
                        $p['rating_count']=$num;
                    }else{
                        $p['rating_count']=0;
                    }
            }

            if(!empty($product->count() > 0)){
                        return $this->sendResponse_product($product,'Product retrieved successfully.');
            }else{
                return $this->sendError('Product not found.'); 
            }
        }
        else{
            return $this->sendError('Fill Required data!'); 
        }
    }

    // retrive all product with sale
    public function sale_product_list_old(Request $request)
    {
        if($request->user_id){
            // $today =\Carbon\Carbon::now()->format('Y-m-d H:i:s');
            $today =\Carbon\Carbon::now()->format('Y-m-d');
            // dd("2021-04-09" >= $today);
            // $sale = Sale::where('sale_end_date','>=',$today)->get();
            // $getalldata = Sale::with('product','product.images','product.size','product.color')
            //                 ->where('sale_end_date','>=',$today)->get();

        $getall_product = Product::with('images','size','color')->orderBy('id', 'desc')->paginate(10);
        
        $getalldata = Sale::  
        where('sale_end_date','>=',$today)->orderBy('id', 'desc')->paginate(10);
        // where('sale_end_date','>=',$today)->get();

        $Favorite = Favourites::where('user_id', '=' ,$request->user_id)->get();
            
        // dd(!empty($getalldata->count() >0));

            if(!empty($getalldata->count() >0)){
                
            $is_fav="";
            foreach($getalldata as $dataf){
                $productdata = $dataf->product;
                foreach($productdata as $f){
                    $p_id = $f->id;
                    $getresult  = Favourites::
                    where('user_id', '=' ,$request->user_id)
                    ->where('product_id', '=' ,$p_id)->first();
                    
                    if(!empty($getresult)){
                        $is_fav=$getresult->status;
                        //dd($is_fav);
                        $f['is_fav']=$is_fav;
                        //dd($p);
                    }else{
                        $f['is_fav']=0;
                    }
                }    
            }

            $rating_count ="";
            foreach($getalldata as $datap){
                // dd($p->product);
                $productdata = $datap->product;
                foreach($productdata as $p){
                    // dd($p->id);
                    $pid = $p->id;
                    $rates = DB::table('ratings')
                    ->where('product_id', $pid)
                    ->avg('rating_avg');
                    // if(!empty($rates)){
                    //     $p['rating_count']=$rates;
                    //     // $p->product['rating_count']=$rates;
                    // }else{
                    //     $p['rating_count']=0;
                    //     // $p->product['rating_count']=0;
                    // }
                    $num = (double) $rates;
                        if(!empty($num)){
                            $p['rating_count']=$num;
                        }else{
                            $p['rating_count']=0;
                        }
                }
            }
                return $this->sendResponse_product($getalldata,'Product retrieved successfully.');
            }else{
                $is_fav="";
                foreach($getall_product as $p){
                 $pid = $p->id;
                    $getresult  = Favourites::
                        where('user_id', '=' ,$request->user_id)
                        ->where('product_id', '=' ,$pid)->first();
                        if(!empty($getresult)){
                            $is_fav=$getresult->status;
                            //dd($is_fav);
                            $p['is_fav']=$is_fav;
                            //dd($p);
                        }else{
                            $p['is_fav']=0;
                        }
                }

            $rating_count ="";
            foreach($getall_product as $p){
                $pid = $p->id;
                    $rates = DB::table('ratings')
                    ->where('product_id', $pid)
                    ->avg('rating_avg');

                    $num = (double) $rates;
                    if(!empty($num)){
                        $p['rating_count']=$num;
                    }else{
                        $p['rating_count']=0;
                    }
            }
                return $this->sendResponse_product($getall_product,'Product retrieved successfully.');
            }
        }
        else{
            return $this->sendError('Fill Required data!'); 
        }
    }

    // retrive all product details sale wise
    public function sale_product_details_old(Request $request)
    {
        if($request->user_id && $request->sale_id){
            // $data = 
            $product = Product::with('images','size','color')
                            ->where('sale_id',$request->sale_id)->orderBy('id','desc')->paginate(10);
                            // ->where('sale_id',$request->sale_id)->get();

            $user = Favourites::where('user_id', '=' ,$request->user_id)->get();
            
            $is_fav="";
                foreach($product as $p){
                $pid = $p->id;
                    $getresult  = Favourites::
                        where('user_id', '=' ,$request->user_id)
                        ->where('product_id', '=' ,$pid)->first();
                        if(!empty($getresult)){
                            $is_fav=$getresult->status;
                            //dd($is_fav);
                            $p['is_fav']=$is_fav;
                            //dd($p);
                        }else{
                            $p['is_fav']=0;
                        }
                }

            $rating_count ="";
            foreach($product as $p){
                $pid = $p->id;
                    $rates = DB::table('ratings')
                    ->where('product_id', $pid)
                    ->avg('rating_avg');

                    $num = (double) $rates;
                    if(!empty($num)){
                        $p['rating_count']=$num;
                    }else{
                        $p['rating_count']=0;
                    }
            }

            if(!empty($product)){
                        return $this->sendResponse_product($product,'Product retrieved successfully.');
            }else{
                return $this->sendError('Product not found.'); 
            }
        }
        else{
            return $this->sendError('Fill Required data!'); 
        }
    }

    // retrive all product
    public function product_list(Request $request)
    {
        if($request->user_id){
            $product = Product::with('images','size','color')->orderBy('id', 'desc')->paginate(40);
            // $product = Product::with('images','size','color')->get();
            $user = Favourites::where('user_id', '=' ,$request->user_id)->get();
            
            $is_fav="";
                foreach($product as $p){
                $pid = $p->id;
                    $getresult  = Favourites::
                        where('user_id', '=' ,$request->user_id)
                        ->where('product_id', '=' ,$pid)->first();
                        if(!empty($getresult)){
                            $is_fav=$getresult->status;
                            //dd($is_fav);
                            $p['is_fav']=$is_fav;
                            //dd($p);
                        }else{
                            $p['is_fav']=0;
                        }
                }

            $rating_count ="";
            foreach($product as $p){
                $pid = $p->id;
                    $rates = DB::table('ratings')
                    ->where('product_id', $pid)
                    ->avg('rating_avg');

                    $num = (double) $rates;
                    if(!empty($num)){
                        $p['rating_count']=$num;
                    }else{
                        $p['rating_count']=0;
                    }
            }

        	// $product = $product->paginate(2);
            if(!empty($product)){
                        return $this->sendResponse_product($product,'Product retrieved successfully.');
            }else{
                return $this->sendError('Product not found.'); 
            }
        }
        else{
            return $this->sendError('Fill Required data!'); 
        }
    }

    public function product_search(Request $request)
    {
        if($request->user_id){
            $search =$request->search;

            $product = Product::with('images','color','size')
            ->orwhereHas('category', function($q) use ($search){
                $q->where('product_name', "like", "%{$search}%");
                $q->orwhere('cat_name', "like", "%{$search}%");
            // })->get();
            })
            ->orwhereHas('subcategory', function($q) use ($search){
                $q->where('product_name', "like", "%{$search}%");
                $q->orwhere('sub_cat_name', "like", "%{$search}%");
            })
            ->orwhereHas('brand', function($q) use ($search){
                $q->where('product_name',"like", "%{$search}%");
                $q->orwhere('brand',"like", "%{$search}%");
            })->get();

            $is_fav="";
            foreach($product as $p){
            $pid = $p->id;
                $getresult  = Favourites::
                    where('user_id', '=' ,$request->user_id)
                    ->where('product_id', '=' ,$pid)->first();
                    if(!empty($getresult)){
                        $is_fav=$getresult->status;
                        //dd($is_fav);
                        $p['is_fav']=$is_fav;
                        //dd($p);
                    }else{
                        $p['is_fav']=0;

                    }
            }

            $rating_count ="";
            foreach($product as $p){
                $pid = $p->id;
                    $rates = DB::table('ratings')
                    ->where('product_id', $pid)
                    ->avg('rating_avg');

                    $num = (double) $rates;
                    if(!empty($num)){
                        $p['rating_count']=$num;
                    }else{
                        $p['rating_count']=0;
                    }
            }

            // dd($product);
            if (!empty($request->search)) {
                    return $this->sendResponse_product($product,'Search Data Loaded Successfully.');
            }
            else{
                return $this->sendResponse_product($product,'All Loaded Successfully.');
            }
        }
        else{
            return $this->sendError('Fill Required data!'); 
        }
       
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
        // $product = Product::where('sub_cat_id',$request->input('sub_cat_id'))->get();
        $product = Product::with('size','color','images')->where('sub_cat_id',$request->input('sub_cat_id'))->get();


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
        if (!empty($request->sub_cat_id)) {
            $result = array();
            $filter = Product::with('category','images','size','color')
            ->where('sub_cat_id',$request->sub_cat_id)->get();

            // $filter = Product::with('subcategory')->select('products.*')->where('sub_cat_id',$request->sub_cat_id);
            // $filter = $filter->join('categories', 'products.cat_id', '=', 'categories.id');

            if(!empty($request->color)){
                $filter = $filter->where('products.color', 'like', '%' . $request->color . '%');
                // return $this->sendResponse_product($product,'Product retrieved successfully.');
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

            $json['success'] = 1;
            $json['message'] = 'All loaded successfully.';
            // $json['result'] = $result;
            $json['result'] = $filter;
        }
        else{
        $json['success'] = 0;
        $json['message'] = 'Fill sub_cat_id';
        }
        echo json_encode($json);
        
    }

    public function filter_product_test(Request $request)  
    {
        $name ="";
        $color =$request->color;
        $size = explode(",", $request->size);  
        $brand = explode(",", $request->brand);  

        $price = explode(",", $request->price);
        $min_price = implode(",", $price);
        $max_price = array_pop($price);

        // $product = Product::with('images','color','size')
        $product = Product::
       orwhereHas('color', function($q) use ($color,$name){
           $q->where('product_name', "=", $name);
           $q->where('color', "like", "%{$color}%");
        // })->get();
        })
        ->orwhereHas('size', function($q) use ($size,$name){
            // $q->where('product_name', "=", $name);
            $q->whereIn('size',$size);
        })
        ->orwhereHas('brand', function($q) use ($brand,$name){
            // $q->where('product_name', "=", $name);
            $q->whereIn('brand',$brand);
        })->get();

        dd($product);

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

    public function filter_product_get(Request $request)
    {
        if (!empty($request->sub_category_id)) {
            $sorting  = Catalog::where('sub_category_id',$request->sub_category_id);
            $getalldata = $sorting->get();

            $min = $getalldata->min('catalog_amount');
            $max = $getalldata->max('catalog_amount');

            if($getalldata->count()>0){
            foreach($getalldata as $key=>$singledata)
            {
                $size[] = array('size'=>$singledata->catalog_size);
                $brand[] = array('brand'=>$singledata->catalog_brand);
                // $size[] = $singledata->catalog_size;
                // $brand[] = $singledata->catalog_brand;
            }

            // $result = array();
            // $result['new'] = $size;
            // dd($size);
            // $size = "s";
            // $brand = "new";
            // if($size && $color && $brand && $min && $max){
            if($size && $brand && $min && $max){
                $json['success'] = 1;
                $json['message'] = 'All loaded successfully.';
                $json['min_price'] = $min;
                $json['max_price'] = $max;
                $json['get_size'] = $size;
                $json['get_brand'] = $brand;
                // $json['catalog_list'] = $getalldata;
            }
            else{
                $json['success'] = 0;
                $json['message'] = 'Data not found';
            }
        }
        else{
            $json['success'] = 0;
            $json['message'] = 'subcategory  not found';
        }
        }
        else{
            $json['success'] = 0;
            $json['message'] = 'Fill sub_cat_id';
        }
        echo json_encode($json);
    }

    public function filter_product_get_product(Request $request)
    {
        if (!empty($request->sub_cat_id)) {
            $filter = Product::with('size','color','brand')
            ->where('sub_cat_id',$request->sub_cat_id)->get();

            $size = Size::where('size_subcat_id',$request->sub_cat_id)->get();
            $color = Color::where('color_subcat_id',$request->sub_cat_id)->get();
            $brand = Brand::where('brand_subcat_id',$request->sub_cat_id)->get();
            // dd($color);
            
            $min = $filter->min('price');
            $max = $filter->max('price');

            // foreach($filter as $s)
            // {
            //     $size[] = $s->size;
            // }
            // dd($size);
            if($size && $color && $brand && $min && $max){
                $json['success'] = 1;
                $json['message'] = 'All loaded successfully.';
                $json['min_price'] = $min;
                $json['max_price'] = $max;
                $json['get_size'] = $size;
                $json['get_color'] = $color;
                $json['get_brand'] = $brand;
                // $json['product_list'] = $filter;
            }
            else{
                $json['success'] = 0;
                $json['message'] = 'Data not found';
            }

        }
        else{
            $json['success'] = 0;
            $json['message'] = 'Fill sub_cat_id';
        }
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

    public function sort_by_product(Request $request)
    {
        if($request->sub_cat_id && $request->user_id ){
            $result = array();
            $sorting = Product::with('images','size','color')->where('sub_cat_id',$request->sub_cat_id);
            $sorting_all = $sorting->get();
        // $sorting = $sorting->orderBy('id','desc')->pluck('id');
        // dd($sorting);

            $is_fav="";
            foreach($sorting_all as $p){
            $pid = $p->id;
                $getresult  = Favourites::
                    where('user_id', '=' ,$request->user_id)
                    ->where('product_id', '=' ,$pid)->first();
                    if(!empty($getresult)){
                        $is_fav=$getresult->status;
                        //dd($is_fav);
                        $p['is_fav']=$is_fav;
                        //dd($p);
                    }else{
                        $p['is_fav']=0;
                    }
            }

            $rating_count ="";
            foreach($sorting as $p){
                $pid = $p->id;
                    $rates = DB::table('ratings')
                    ->where('product_id', $pid)
                    ->avg('rating_avg');

                    $num = (double) $rates;
                    if(!empty($num)){
                        $p['rating_count']=$num;
                    }else{
                        $p['rating_count']=0;
                    }
            }

            $sorting_data = $request->sorting_data; 
        
            if($sorting_data == 1){
                $sorting_all = $sorting->orderBy('id','desc')->get();
                $is_fav="";
                foreach($sorting_all as $p){
                   $pid = $p->id;
                    $getresult  = Favourites::
                        where('user_id', '=' ,$request->user_id)
                        ->where('product_id', '=' ,$pid)->first();
                        if(!empty($getresult)){
                            $is_fav=$getresult->status;
                            //dd($is_fav);
                            $p['is_fav']=$is_fav;
                            //dd($p);
                        }else{
                            $p['is_fav']=0;
                        }
                }
                $rating_count ="";
                foreach($sorting_all as $p){
                    $pid = $p->id;
                        $rates = DB::table('ratings')
                        ->where('product_id', $pid)
                        ->avg('rating_avg');
    
                        $num = (double) $rates;
                        if(!empty($num)){
                            $p['rating_count']=$num;
                        }else{
                            $p['rating_count']=0;
                        }
                }
                return $this->sendResponse_product($sorting_all,'Product retrieved successfully.'); 
            }
            elseif($sorting_data == 2){
                $sorting = $sorting->orderBy('price')->get();
                return $this->sendResponse_product($sorting,'Product retrieved successfully.'); 
            }
            elseif($sorting_data == 3){
                $sorting = $sorting->orderBy('price','desc')->get();
                return $this->sendResponse_product($sorting,'Product retrieved successfully.'); 
            }
            elseif($sorting_data == 4){
                $rates = Rating::orderBy('rating_avg','desc')->get();
                foreach($rates as $r){
                    $p_id[] = $r->product_id;
                }
                // dd($p_id);
                $sorting = $sorting->whereIn('id',$p_id)->orderBy('id','desc')->get();
                return $this->sendResponse_product($sorting,'Product retrieved successfully.'); 
            }

            elseif($sorting_data == 5){
                $cart = Cart::get();
                foreach($cart as $c){
                    $c_p_id[] = $c->product_id;
                }

                $fav = Favourites::get();
                foreach($fav as $f){
                    $f_p_id[] = $f->product_id;
                }
                // dd($c_p_id);
                $i['c'] = $c_p_id;
                $i['f'] = $f_p_id;
                
                $sorting = $sorting->whereIn('id',$c_p_id)
                ->orwhereIn('id',$f_p_id)->where('sub_cat_id',$request->sub_cat_id)->get();
                // $sorting = $sorting->get();
                return $this->sendResponse_product($sorting,'Product retrieved successfully.'); 
            }

            else{
                return $this->sendResponse_product($sorting_all,'Product retrieved successfully.'); 
            }
        }
        else{
            return $this->sendError('Fill Required data!'); 
        }
    }

    public function sort_by_product__(Request $request)
    {
        if($request->sub_cat_id && $request->user_id ){
            $result = array();
            $sorting = Product::with('images','size','color')->where('sub_cat_id',$request->sub_cat_id);
            $sorting = $sorting->get();
        // $sorting = $sorting->orderBy('id','desc')->pluck('id');
        // dd($sorting);

            $is_fav="";
            foreach($sorting as $p){
            $pid = $p->id;
                $getresult  = Favourites::
                    where('user_id', '=' ,$request->user_id)
                    ->where('product_id', '=' ,$pid)->first();
                    if(!empty($getresult)){
                        $is_fav=$getresult->status;
                        //dd($is_fav);
                        $p['is_fav']=$is_fav;
                        //dd($p);
                    }else{
                        $p['is_fav']=0;
                    }
            }

            $rating_count ="";
            foreach($sorting as $p){
                $pid = $p->id;
                    $rates = DB::table('ratings')
                    ->where('product_id', $pid)
                    ->avg('rating_avg');

                    $num = (double) $rates;
                    if(!empty($num)){
                        $p['rating_count']=$num;
                    }else{
                        $p['rating_count']=0;
                    }
            }

        
            if(!empty($request->newest == 'newest')){
                $sorting = $sorting->orderBy('id','desc')->get();
                return $this->sendResponse_product($sorting,'Product retrieved successfully.'); 
            }
            elseif(!empty($request->lowest_to_high == 'lowest')){
                $sorting = $sorting->orderBy('price')->get();
                return $this->sendResponse_product($sorting,'Product retrieved successfully.'); 
            }
            elseif(!empty($request->highest_to_low == 'highest')){
                $sorting = $sorting->orderBy('price','desc')->get();
                return $this->sendResponse_product($sorting,'Product retrieved successfully.'); 
            }
            elseif(!empty($request->customer_review == 'review')){
                $rates = Rating::orderBy('rating_avg','desc')->get();
                foreach($rates as $r){
                    $p_id[] = $r->product_id;
                }
                // dd($p_id);
                $sorting = $sorting->whereIn('id',$p_id)->orderBy('id','desc')->get();
                return $this->sendResponse_product($sorting,'Product retrieved successfully.'); 
            }

            elseif(!empty($request->popular == 'popular')){
                $cart = Cart::get();
                foreach($cart as $c){
                    $c_p_id[] = $c->product_id;
                }

                $fav = Favourites::get();
                foreach($fav as $f){
                    $f_p_id[] = $f->product_id;
                }
                // dd($c_p_id);
                $i['c'] = $c_p_id;
                $i['f'] = $f_p_id;
                // dd($i);

                // $s = explode(",", $c_p_id);  
                // $sorting = $sorting->whereIn('id',$i)->where('sub_cat_id',$request->sub_cat_id)->get();
                
                $sorting = $sorting->whereIn('id',$c_p_id)
                ->orwhereIn('id',$f_p_id)->where('sub_cat_id',$request->sub_cat_id)->get();
                // $sorting = $sorting->get();
                return $this->sendResponse_product($sorting,'Product retrieved successfully.'); 
            }

            else{
                return $this->sendResponse_product($sorting,'Product retrieved successfully.'); 
            }
        }
        else{
            return $this->sendError('Fill Required data!'); 
        }
    }

}
