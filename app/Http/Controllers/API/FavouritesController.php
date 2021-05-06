<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\Product;
use App\Models\Category;
use App\Models\Favourites;
use App\Models\Catalog;
use App\User;
use Validator;
use Str;
use File;
use DB;

class FavouritesController extends BaseController
{

# start catalog favourite
    public function AddFavouriteProduct(Request $request)
	{
        if (!empty($request->catalog_id && $request->user_id && $request->status)) {
            $catalog = Catalog::find($request->input('catalog_id'));
            $user = User::find($request->input('user_id'));
            // dd(!empty($catalog && $user));
            if(!empty($catalog && $user)){
                $data = Favourites::where('catalog_id', '=', trim($request->catalog_id))
                ->where('user_id', '=', trim($request->user_id))
                // ->where('status', '=', trim($request->status))
                ->first();
                if (!empty($data)) {
                    $data->status  = $request->status;
                    $data->save();
                    $json['success'] = 1;
                    $json['message'] = 'Added to wishlist.';
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
            $json['message'] = 'User Or catalog Not Found!';
            }
        }
        else{
        $json['success'] = 0;
        $json['message'] = 'Fill user_id, catalog_id and status';
        }
        echo json_encode($json);
    }
    public function getFavouriteList(Request $request)
	{
        $getresult  = Favourites::with('catalog')->where('status',1)->where('user_id', '=' ,$request->user_id)->get();
        // $rating_count ="";
        //     foreach($getresult as $p){
        //         $pid = $p->product_id;
        //         // dd($pid);
        //             $rates = DB::table('ratings')
        //             ->where('product_id', $pid)
        //             ->avg('rating_avg');

        //             $num = (double) $rates;
        //             if(!empty($num)){
        //                 $p['rating_count']=$num;
        //             }else{
        //                 $p['rating_count']=0;
        //             }
        //     }
        // dd($getresult);
        foreach($getresult as $getcatalog)
            {
                // $getcatalog->catalog['newtest'] = "0";
                    $product_id = $getcatalog->catalog->product_id;
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
                    $getcatalog->catalog['product_list'] = $product;
            }

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
        if (!empty($request->catalog_id && $request->user_id)) {
            // dd(!empty($product && $user));
                $data = Favourites::where('catalog_id', '=', trim($request->catalog_id))
                ->where('user_id', '=', trim($request->user_id))
                // ->where('status', '=', trim($request->status))
                ->first();
                // dd(!empty($data));
                if (!empty($data)) {
                    $data->status  = '0';
                    $data->save();
                    $json['success'] = 1;
                    $json['message'] = 'Item deleted Successfully';
                    $json['favourite_list'] = $data;
                }else{
                    $json['success'] = 0;
                    $json['message'] = 'Data not found.';
                }
        }
        else{
        $json['success'] = 0;
        $json['message'] = 'Fill Required Data';
        }
        echo json_encode($json);
    }
# end catalog favourite

# start product favourite
    public function AddFavouriteProduct_product(Request $request)
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
                    $json['message'] = 'Added to wishlist.';
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

    public function getFavouriteList_product(Request $request)
	{
	    // $result  = array();
		// $getresult  = Favourites::with('user','product')->where('user_id', '=' ,$request->user_id)->where('product_id', '=' ,$request->product_id)->get();
		// $getresult  = Favourites::with('product')->where('user_id', '=' ,$request->user_id)->get();
        $getresult  = Favourites::with('product','product.images','product.color','product.size')->where('status',1)->where('user_id', '=' ,$request->user_id)->get();

        $rating_count ="";
            foreach($getresult as $p){
                $pid = $p->product_id;
                // dd($pid);
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

    public function deleteFavouriteProdcut_product(Request $request)
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
                    $json['message'] = 'Item deleted Successfully';
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
# end product favourite
 
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

// --------- using base controller ----start-------
      public function add_favourite___backup(Request $request)
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
}
