<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Rating;
use App\Models\Rating_images;
use App\Models\Favourites;
use App\User;
use Validator;
use Str;
use File;
use DB;

class Ratingscontroller extends Controller
{
    public function app_product_rating_list(Request $request)
    {
        if (!empty($request->product_id && $request->user_id )) {
          
            $rates = Rating::with('user')
            ->where('product_id', '=' ,$request->product_id)
            ->get();

            $getresult  = Rating::with('product')
                ->where('product_id', '=' ,$request->product_id)
                ->where('user_id', '=' ,$request->user_id)->get();

            $avg = $rates->avg('rating_avg');
            $rating_sum = $rates->sum('rating_avg');
            $total_user = $rates->count('product_id');
            $five_rate = $rates->where('rating_avg','=','5')->count('product_id');
            $four_rate = $rates->where('rating_avg','=','4')->count('product_id');
            $three_rate = $rates->where('rating_avg','=','3')->count('product_id');
            $two_rate = $rates->where('rating_avg','=','2')->count('product_id');
            $one_rate = $rates->where('rating_avg','=','1')->count('product_id');

            // dd($one_rate);

            $is_fav="";
                foreach($rates as $p){
                    $fav  = Favourites::
                        where('user_id', '=' ,$request->user_id)
                        ->where('product_id', '=' ,$request->product_id)->first();
                        if(!empty($fav)){
                            $is_fav=$fav->status;
                            //dd($is_fav);
                            $p['is_fav']=$is_fav;
                            //dd($p);
                        }else{
                            $p['is_fav']=0;
                        }
                }

                foreach($rates as $r){
                    $r['raing_average'] = $avg;
                    $r['raing_sum'] = $rating_sum;
                    $r['five_rating'] = $five_rate;
                    $r['four_rating'] = $four_rate;
                    $r['three_rating'] = $three_rate;
                    $r['two_rating'] = $two_rate;
                    $r['one_rating'] = $one_rate;
                    $rating_date[] = $r->created_at->format('Y-m-d H:i:s');
                    $rating_add[] = $r->rating_avg;
                }

                // dd($rating_add);
                foreach($rates as $key=>$u){
                    // dd($u->user->username);
                    $u->user['rating_date'] = $rating_date[$key];
                    $u->user['rating'] = $rating_add[$key];
                } 

            if(!empty($rates->count() > 0)){
                $json['success'] = 1;
                $json['message'] = 'Rating loaded Successfully.';
                $json['rating_list'] = $rates;
            }
            else{
                $json['success'] = 0;
                $json['message'] = 'User or  Product not found.';
            }
        }
        else{
            $json['success'] = 0;
            $json['message'] = 'Fill user_id and product_id';
        }
        echo json_encode($json);
    }

    public function app_product_rating_add_single_images(Request $request)
	{
        if (!empty($request->product_id && $request->user_id)) {
            $product = Product::find($request->input('product_id'));
            $user = User::find($request->input('user_id'));
            // dd(!empty($product && $user));
            if(!empty($product && $user)){
                $data = Rating::where('product_id', '=', trim($request->product_id))
                ->where('user_id', '=', trim($request->user_id))
                ->first();
              
                if (!empty($data)) {
                    $data->status  = 1;
                    $data->product_id = $request->product_id;
                    $data->user_id = $request->user_id;
                    $data->rating_avg = $request->rating_avg;
                    $data->rating_description = $request->rating_description;
                    $data->save();

                    $rates = DB::table('ratings')
                    ->where('product_id', $data->product_id)
                    ->avg('rating_avg');

                    $product = Product::where('id','=',$request->product_id)->first();
                    $product->rating_count  = $rates;
                    $product->save();

                    $json['success'] = 1;
                    $json['message'] = 'Rating change Successfully.';
                    $json['rating_list'] = $data;
                }else{
                    $input = $request->all();
                    // $rating = new Rating;
                    if($request->hasfile('rating_images')) {
                        foreach($request->file('rating_images') as $file){
                                $no = rand(1111,9999);
                                $image_name = time().$no.'.jpg';
                                $file->move(public_path('images/rating'), $image_name);
                                $data[] = $image_name;

                                $rating = new Rating([
                                    'product_id' => $request->product_id,
                                    'user_id' => $request->user_id,
                                    'rating_avg' => $request->rating_avg,
                                    'rating_description' => $request->rating_description,
                                    'rating_images'            =>  $image_name,
                                    'status'            =>  1,
                                ]);
                                    // dd($rating);
                                }
                                $rating->save();
                        }

                    $json['success'] = 1;
                    $json['message'] = 'Rating add Successfully.';
                    $json['rating_list'] = $rating;
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

    public function app_product_rating_add(Request $request)
	{
        if (!empty($request->product_id && $request->user_id)) {
            $product = Product::with('size','color','images')->find($request->input('product_id'));
            $user = User::find($request->input('user_id'));
            // dd(!empty($product && $user));
            if(!empty($product && $user)){
                $data = Rating::with('ratingimages')->where('product_id', '=', trim($request->product_id))
                ->where('user_id', '=', trim($request->user_id))
                ->first();
              
                if (!empty($data)) {
                    $data->status  = 1;
                    $data->product_id = $request->product_id;
                    $data->user_id = $request->user_id;
                    $data->rating_avg = $request->rating_avg;
                    $data->rating_description = $request->rating_description;
                    $data->save();

                    if($request->hasfile('images')) {
                        $images_remove = Rating_images::where('rating_id','=',$data->id)->delete();
                        // dd($images_update);

                        foreach($request->file('images') as $file){
                            // $image_name = time().'-'.$file->getClientOriginalName();
                            $no = rand(1111,9999);
                            $image_name = time().$no.'.jpg';
                            $file->move(public_path('images/rating'), $image_name);
                            // $input['images']=json_encode($data);
                            $new[] = $image_name;
                            // dd($new);
                                $image =  Rating_images::create([
                                    'rating_id'        => $data->id,
                                    'images'           => $image_name,
                                ]);
                        }
                        // dd($new);
                    }
                      // store single image on product table
                      $rat_img = Rating::find($data->id);
                      $rat_img->rating_images = $new[0];
                      $rat_img->save();

                    $rates = DB::table('ratings')
                    ->where('product_id', $data->product_id)
                    ->avg('rating_avg');

                    // $product = Product::where('id','=',$request->product_id)->first();
                    // $product->rating_count  = $rates;
                    // $product->save();

                    $json['success'] = 1;
                    $json['message'] = 'Thanks for the rating!';
                    $json['rating_list'] = $data;
                }else{
                    $input = $request->all();
                    $rating = new Rating;
                    $rating->product_id = $request->product_id;
                    $rating->user_id = $request->user_id;
                    $rating->rating_avg = $request->rating_avg;
                    $rating->rating_description    = $request->rating_description;
                    $rating->status    = '1';
                    $rating->save();

                    if($request->hasfile('images')) {
                        foreach($request->file('images') as $file){
                                // $image_name = time().'-'.$file->getClientOriginalName();
                                $no = rand(1111,9999);
                                $image_name = time().$no.'.jpg';
                                $file->move(public_path('images/rating'), $image_name);
                                // $input['images']=json_encode($data);
                                $data[] = $image_name;
                                
                                $image =  Rating_images::create([
                                    'rating_id'        => $rating->id,
                                    'images'           => $image_name,
                                ]);
                        }
                        // dd($data);
                    }

                     // store single image on product table
                    $rat_img = Rating::find($rating->id);
                    $rat_img->rating_images = $data[0];
                    $rat_img->save();

                    $rat_data = $data = Rating::with('ratingimages')->where('product_id', '=', trim($request->product_id))
                    ->where('user_id', '=', trim($request->user_id))
                    ->first();

                    $json['success'] = 1;
                    $json['message'] = 'Thanks for the rating!';
                    $json['rating_list'] = $rat_data;
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

    public function app_product_rating_list_byproduct(Request $request)
    {
        if (!empty($request->product_id && $request->user_id )) {
            $getresult  = Rating::with('product')
            ->where('product_id', '=' ,$request->product_id)
            ->where('user_id', '=' ,$request->user_id)->get();

            $is_fav="";
                foreach($getresult as $p){
                    $fav  = Favourites::
                        where('user_id', '=' ,$request->user_id)
                        ->where('product_id', '=' ,$request->product_id)->first();
                        if(!empty($fav)){
                            $is_fav=$fav->status;
                            //dd($is_fav);
                            $p['is_fav']=$is_fav;
                            //dd($p);
                        }else{
                            $p['is_fav']=0;
                        }
                }

            if(!empty($getresult->count() > 0)){
                $json['success'] = 1;
                $json['message'] = 'Rating loaded Successfully.';
                $json['rating_list'] = $getresult;
            }
            else{
                $json['success'] = 0;
                $json['message'] = 'User or  Product not found.';
            }
        }
        else{
            $json['success'] = 0;
            $json['message'] = 'Fill user_id and product_id';
        }
        echo json_encode($json);
    }

    public function app_rating_helpful(Request $request)
    {
        if (!empty($request->user_id )) {
            $json['success'] = 0;
            $json['message'] = 'Fill user_id and product_id';
        }
        else{
            $json['success'] = 0;
            $json['message'] = 'Fill user_id ';
        }
        echo json_encode($json);
    }

    // public function app_product_rating_update(Request $request)
	// {
    //     if (!empty($request->product_id && $request->user_id && $request->rating_avg)) {
    //         $product = Product::find($request->input('product_id'));
    //         $user = User::find($request->input('user_id'));

    //         if(!empty($product && $user)){
    //             $data = Rating::where('product_id', '=', trim($request->product_id))
    //             ->where('user_id', '=', trim($request->user_id))
    //             ->first();

    //             if(!empty($data))
    //             {
    //                 $data->rating_avg  = trim($request->rating_avg);
    //                 $data->save();
    //                 $json['success'] = 1;
    //                 $json['message'] = 'Rating change Successfully';
    //                 $json['rating_list'] = $data;
    //             }
    //             else{
    //                 $json['success'] = 0;
    //                 $json['message'] = 'Rating Product not found.';
    //             }
    //         }
    //         else{
    //         $json['success'] = 0;
    //         $json['message'] = 'User Or Product Not Found!';
    //         }
    //     }
    //     else{
    //     $json['success'] = 0;
    //     $json['message'] = 'Fill user_id and product_id and rating_avg';
    //     }
    //     echo json_encode($json);
    // }
}
