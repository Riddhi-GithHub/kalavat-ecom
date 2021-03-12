<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Rating;
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
            $getresult  = Rating::with('product')
            ->where('product_id', '=' ,$request->product_id)
            ->where('user_id', '=' ,$request->user_id)->get();

            if(!empty($getresult->count() > 0)){
                $json['success'] = 1;
                $json['message'] = 'Rating loaded Successfully.';
                $json['favourite_list'] = $getresult;
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

    public function app_product_rating_update(Request $request)
	{
        if (!empty($request->product_id && $request->user_id && $request->rating_avg)) {
            $product = Product::find($request->input('product_id'));
            $user = User::find($request->input('user_id'));

            if(!empty($product && $user)){
                $data = Rating::where('product_id', '=', trim($request->product_id))
                ->where('user_id', '=', trim($request->user_id))
                ->first();

                if(!empty($data))
                {
                    $data->rating_avg  = trim($request->rating_avg);
                    $data->save();
                    $json['success'] = 1;
                    $json['message'] = 'Rating change Successfully';
                    $json['favourite_list'] = $data;
                }
                else{
                    $json['success'] = 0;
                    $json['message'] = 'Rating Product not found.';
                }
            }
            else{
            $json['success'] = 0;
            $json['message'] = 'User Or Product Not Found!';
            }
        }
        else{
        $json['success'] = 0;
        $json['message'] = 'Fill user_id and product_id and rating_avg';
        }
        echo json_encode($json);
    }

    public function app_product_rating_add(Request $request)
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
                    $json['favourite_list'] = $data;
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
                    $json['favourite_list'] = $rating;
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
