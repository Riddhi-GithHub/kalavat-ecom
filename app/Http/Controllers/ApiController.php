<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Models\Favourites;
use App\Models\Slider;
use App\Models\Version_Setting;
use App\Models\Cart;
use App\Models\Category;
use App\Models\Sub_Category;
use App\Models\Product;
use App\Models\Brand;
use App\Models\Color;
use App\Models\Catalog;
use Hash;
use Validator;
use Auth;
use Str;
use File;
use DB;
use Mail;

class ApiController extends Controller
{
    public $token;

	public function __construct(Request $request) {
		
		$this->token = !empty($request->header('token'))?$request->header('token'):'';
	}
	public function sendEmailVerificationNotification()
    {
        $this->notify(new VerifyEmail);
    }

	# app_catlog
	public function app_catlog_list(Request $reques)
	{
		$getresult  = Catalog::get();
		
		if(!empty($getresult)){
			
			foreach($getresult as $result){
				$product_id = $result->product_id;
				$array_product_id = explode(',', $product_id);
				$product = Product::with('images','size','color')->whereIn('id',$array_product_id)->get();
				$result['product_list'] = $product;
			}
		
			$json['status'] = 1;
			$json['message'] = 'Catalog list Loaded Successfully.';
			$json['catalog_list'] = $getresult;
		}
		else{
			$json['status'] = 0;
			$json['message'] = 'Data not Found.';
		}
        echo json_encode($json);
	}


    public function app_login(Request $request)
    {
		if (!empty($request->mobile && $request->otp)) {
            $user = User::where('mobile', '=', trim($request->mobile))->where('otp', '=', trim($request->otp))->first();
		     if (!empty($user)) {
		         if (!empty($user->otp_verify == 1)) {
                    $json['status'] = 1;
				    $json['message'] = 'Login successfully.';
                } else {
                    $json['status'] = 0;
                    $json['message'] = 'Otp not Verified!';
                }
            } else {
                $json['status'] = 0;
                $json['message'] = 'Mobile number and otp not match!';
            }
        } else {
            $json['status'] = 0;
            $json['message'] = 'Mobile or otp not found.';
        }
		echo json_encode($json);
    }

    public function app_register(Request $request) 
    {
		if (!empty($request->mobile))
		{
            // dd($request->all());
 			$otp = rand(1111,9999);

				$record = new User;
				$record->mobile = trim($request->mobile);
                $record->otp = 9999;
				$record->save();

                $json['status'] = 1;
				$json['message'] = 'Register Successfully';
                $json['user_data'] = $this->getRegister($record->id);

        } else {
        $json['status'] = 0;
        $json['message'] = 'Parameter missing!';
        }
        echo json_encode($json);
	}
    
    public function resend_mobile_otp(Request $request) 
    {
        // dd($request->mobile);
		if (!empty($request->mobile)) {
			$otp = rand(1111,9999);
			// $otp = 9999;
            $user = User::where('mobile', '=', trim($request->mobile))->first();
		     if (!empty($user)) {
				$user->otp = 9999;
				// $user->otp = $otp;
		    	$message = "Your requested OTP for Mobile Number verification at Bookfast is  9999  Never share this with anyone.";
				// $message = "Your requested OTP for Mobile Number verification at Bookfast is ".$otp."";
				$this->generateOTP($user->mobile, $message, $otp);
                // dd($user);
				$user->save();
				$json['status'] = 1;
				$json['message'] = 'OTP resent successfully.';
			} else {
				$json['status'] = 0;
				$json['message'] = 'Mobile number not found!';
			}
		} else {
			$json['status'] = 0;
			$json['message'] = 'Record not found.';
		}
		echo json_encode($json);
	}


    // register
    public function getRegister($id)
	{
		$user = User::find($id);
		$json['id'] = $user->id;
		// $json['name']          = !empty($user->name) ? $user->name : '';
		// $json['email'] 		   = !empty($user->email) ? $user->email : '';
		$json['mobile']        = !empty($user->mobile) ? $user->mobile : '';
		$json['otp'] 		   = !empty($user->otp) ? $user->otp : '';
			
		$getuserID = User::where('id', '=', $user->user_id)->first();

		return $json;
	}


    // for login 
    public function getProfileUser($id)
	{
		$user  = User::find($id);
		// dd($user);
		// die();
		// $json['id']            = $user->id;
		// $json['name']          = !empty($user->name) ? $user->name : '';
		$json['otp'] 		   = !empty($user->otp) ? $user->otp : '';
		$json['mobile']        = !empty($user->mobile) ? $user->mobile : '';
		
		return $json;
	}

    // resend otp
    public function generateOTP($mobile, $message, $otp)
    {
        $params = array(
             "mobile"  => $mobile,
		     "message" => $message,
		     "sender"  => 'BookFast',
		     "otp" => $otp
		);

		$postData = '';
        foreach($params as $k => $v) 
        { 
            $postData .= $k . '='.$v.'&'; 
        }
        $postData = rtrim($postData, '&');
        
        $curl = curl_init();

        curl_setopt_array($curl, array(
          CURLOPT_URL => "https://api.msg91.com/api/v5/otp?authkey=353363AQhbr8vQ601a7245P1&mobile=91".$mobile."&message=".$message."&sender=BookFast&otp=".$otp."",
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => "",
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 30,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => "POST",
          CURLOPT_POSTFIELDS => "",
          CURLOPT_SSL_VERIFYHOST => 0,
          CURLOPT_SSL_VERIFYPEER => 0,
          CURLOPT_HTTPHEADER => array(
            "content-type: application/json"
          ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        // if ($err) {
        //   echo "cURL Error #:" . $err;
        // } else {
        //   echo $response;
        // }
      
    }



    public function getFavouriteList(Request $request)
	{
	    $result  = array();
		// $getresult  = Favourites::with('user','product')->where('user_id', '=' ,$request->user_id)->where('product_id', '=' ,$request->product_id)->get();
		$getresult  = Favourites::with('product')->where('user_id', '=' ,$request->user_id)->get();
		// $getresult  = Favourites::get();
		$data = $getresult;
		$result[] = $data;

		// foreach ($getresult as $value) {
		// 	$data['fav_id'] 			   = $value->fav_id ;
			
		// 	$data['user_id']           = !empty($value->user_id) ? $value->user_id : '';
		// 	$data['username']           = !empty($value->user->username) ? $value->user->username : '';
		// 	$data['email']           = !empty($value->user->email) ? $value->user->email : '';
		// 	$data['mobile']           = !empty($value->user->mobile) ? $value->user->mobile : '';

		// 	$data['product_id']           = !empty($value->product_id ) ? $value->product_id  : '';
		// 	$data['product_name']           = !empty($value->product->product_name) ? $value->product->product_name : '';
		// 	$data['img']           = !empty($value->product->img) ? $value->product->img : '';
		// 	$data['description']           = !empty($value->product->description) ? $value->product->description : '';
		// 	$data['price']           = !empty($value->product->price) ? $value->product->price : '';
		// 	$data['quantity']           = !empty($value->product->quantity) ? $value->product->quantity : '';
		// 	$data['offer']           = !empty($value->product->offer) ? $value->product->offer : '';
		// 	$data['color']           = !empty($value->product->color) ? $value->product->color : '';
		// 	$data['size']           = !empty($value->product->size) ? $value->product->size : '';
		// 	$data['brand']           = !empty($value->product->brand) ? $value->product->brand : '';
				
		// 	$result[] = $data;
		// }

		$json['status'] = 1;
		$json['message'] = 'Favourite list loaded successfully.';
		$json['favourite_list'] = $result;

 	    echo json_encode($json);

	}


   // version setting
	public function app_version_setting_update(Request $request)
	{
		// echo "str_in_ddd__ddddg";
		// die();
		$record = Version_Setting::find(1);	  

		if(!empty($record)){
			$record->app_version   = trim($request->app_version);
			$record->save();
			$json['success'] = 1;
			$json['message'] = 'Update App Version.';
			$json['user_data'] = $this->getAppVersionSetting($record->id);
		}
	   else
	    {
		   	$json['success'] = 0;
			$json['message'] = 'Record not found.';
	    }
	    echo json_encode($json);
	}

	public function getAppVersionSetting($id)
	{
		$user 				               = Version_Setting::find($id);
		//$json['id']    		               = $user->id;
		$json['id'] 	               = $user->id;
		//$json['user_id']                   = !empty($user->user_id) ? $user->user_id : '';
		$json['app_version']   = !empty($user->app_version) ? $user->app_version : '';
	
		return $json;	
	}


	// slider list
	public function app_slider_list(Request $request)
    {
        $slider = Slider::get();

        if(!empty($slider->count() > 0)){
            $json['success'] = 1;
            $json['message'] = 'Slider list loaded Successfully.';
            $json['slider_list'] = $slider;
        }
        else{
            $json['success'] = 0;
            $json['message'] = 'Slider not found.';
        }

 	    echo json_encode($json);
    }

	// count cart and favourite
	public function count_list(Request $request)
	{
        $cart = Cart::where('user_id',$request->user_id)->count();
        $fav = Favourites::where('user_id',$request->user_id)->count();

				$data['cart_count']      = $cart;
				$data['fav_count']      = $fav;

			$json['success'] = 1;
			$json['message'] = 'Count loaded Successfully.';
			$json['result'] = $data;
			
			echo json_encode($json);
	}

	# strat forgot password
		public function forgot_password(Request $request)
	 	{
			 $user = User::whereEmail($request->email)->first();
			 $otp = rand(1111,9999);
			 if(($user) == null){
				 return redirect()->back()->with(['error' => 'Email not Exciest']);
			 }else{
			 $user = User::find($user->id);
			 $code = array('username' => "welcome");
			 Mail::send(
				 'Forgot',
				 ['user'=>$user, 'code' =>$code],
				 function($message) use ($user){
					 $message->to($user->email);
					 $message->subject($user->username, "reset your password");
				 }
			 );
				$json['status'] = 1;
				$json['message'] = 'Reset code send to your email.';
			 }
			echo json_encode($json);
			//  return redirect()->back()->with(['success' => 'Reset code send to your email']); 
		}

		public function change_password(Request $request)
		{
			// $user = User::find('id');
			$id = request()->id;
			$user = User::find($id);
			// dd($user);
			return view('changePassword',['user'=>$user]);
		}
		public function store_password(Request $request)
		{
			$request->validate([
				'new_password' => ['required'],
				'new_confirm_password' => ['same:new_password'],
				]);
			
			$user = User::find($request->get('id'));
			$user->password=$request->input('password');
			// $user->password = Hash::make($request->get('new_password'));
			$user->password=$request->input('new_confirm_password');
			$user->save();
	
			return redirect('admin/login')->with('success', 'Password Change Successfully!');  
			// return back()->with('message','password change successfully');
		}
	# end forgot password 


	# banner click
	public function app_banner_click(Request $request)
	{
		if($request->type){
			$type = $request->type;
			// $slider = Slider::where('cat_id',$type)->first();
			// dd($slider->cat_id);
			// $cat = category::where('id',$slider->cat_id)->get();
			// dd($cat);
			$value = [1,2,3];

			// dd(!empty($value));

			if($type == 1){
				$json['success'] = 1;
				$json['message'] = 'Slider Category data';
				$json['type'] = 1;
				$json['type_name'] = 'category';
			}
			elseif($type == 2){
				$json['success'] = 1;
				$json['message'] = 'Slider Subcategory data';
				$json['type'] = 2;
				$json['type_name'] = 'subcategory';
			}
			elseif($type == 3){
				$json['success'] = 1;
				$json['message'] = 'Slider Brand data';
				$json['type'] = 3;
				$json['type_name'] = 'brand';
			}
			elseif(!empty($value)){
				$json['success'] = 1;
				$json['message'] = 'Slider data not found';
			}
		}
		else{
            $json['success'] = 0;
            $json['message'] = 'Fill Required data';
        }
		
		echo json_encode($json);
	}

		public function app_home_page_search_list(Request $request){
		$result  = array();
		// $Category_Array = array();
		$Sub_Categories_Array = array();
		$Product_Array = array();
		$Brand_Array = array();
		$Colors_Array = array();

		$get_category       = Category::orderBy('id', 'desc');
		$get_sub_categories = Sub_Category::orderBy('id', 'desc');
		$get_products       = Product::orderBy('id', 'desc');
		$get_brands         = Brand::orderBy('id', 'desc');
		$get_colors         = Color::orderBy('id', 'desc');
// Category Start
		// if(!empty($request->search)){
		// 	$get_category = $get_category->orwhere('categories.cat_name', 'like', '%' . $request->search . '%');
		// }

		// $get_category = $get_category->paginate(80);

		// foreach ($get_category as $key_value) {
		// 	$data_x['id']               = !empty($key_value->id) ? $key_value->id : '';
		// 	$data_x['cat_name']         = !empty($key_value->cat_name) ? $key_value->cat_name : '';	
		// 	$data_x['image']            = !empty($key_value->image) ? $key_value->image : '';
		// 	// $result[] = $data_x;
		// 	$Category_Array[] = $data_x;
		// }

		// $result['category_list'] = $Category_Array;
// Category End
// Sub Category Start
		if(!empty($request->search)){
			$get_sub_categories = $get_sub_categories->orwhere('sub_categories.sub_cat_name', 'like', '%' . $request->search . '%');
		}

		$get_sub_categories = $get_sub_categories->paginate(80);

		foreach ($get_sub_categories as $keys_value) {
			$data_xy['id']               = !empty($keys_value->id) ? $keys_value->id : '';
			$data_xy['product_name'] = !empty($keys_value->sub_cat_name) ? $keys_value->sub_cat_name : '';	
			$data_xy['colorrr']      = !empty($keys_value->product_s->colorrr) ? $keys_value->product_s->colorrr : '';	
			$data_xy['branddd']      = !empty($keys_value->product_s->branddd) ? $keys_value->product_s->branddd : '';	
			$data_xy['img']          = !empty($keys_value->product_s->img) ? $keys_value->product_s->img : '';	
			$data_xy['sort_desc']    = !empty($keys_value->product_s->sort_desc) ? $keys_value->product_s->sort_desc : '';	
			$data_xy['description']  = !empty($keys_value->product_s->description) ? $keys_value->product_s->description : '';	
			$data_xy['price']        = !empty($keys_value->product_s->price) ? $keys_value->product_s->price : '';	

			// $data_xy['sub_cat_name']     = !empty($keys_value->sub_cat_name) ? $keys_value->sub_cat_name : '';	
			// $data_xy['cat_image']         = !empty($keys_value->category->image) ? $keys_value->category->image : '';	
			// $result[] = $data_xy;
			$Sub_Categories_Array[] = $data_xy;
		}

		$result['category_list'] = $Sub_Categories_Array;
// Sub Category End
// Product Start
		if(!empty($request->search)){
			$get_products = $get_products->orwhere('products.product_name', 'like', '%' . $request->search . '%')->orwhere('products.colorrr', 'like', '%' . $request->search . '%')->orwhere('products.branddd', 'like', '%' . $request->search . '%');
		}

		$get_products = $get_products->paginate(80);

		foreach ($get_products as $keyss_value) {
			$data_xys['id']           = !empty($keyss_value->id) ? $keyss_value->id : '';
			$data_xys['product_name'] = !empty($keyss_value->product_name) ? $keyss_value->product_name : '';	
			$data_xys['colorrr']      = !empty($keyss_value->colorrr) ? $keyss_value->colorrr : '';	
			$data_xys['branddd']      = !empty($keyss_value->branddd) ? $keyss_value->branddd : '';	
			$data_xys['img']          = !empty($keyss_value->img) ? $keyss_value->img : '';	
			$data_xys['sort_desc']    = !empty($keyss_value->sort_desc) ? $keyss_value->sort_desc : '';	
			$data_xys['description']  = !empty($keyss_value->description) ? $keyss_value->description : '';	
			$data_xys['price']        = !empty($keyss_value->price) ? $keyss_value->price : '';	
			// $result[] = $data_xys;
			$Product_Array[] = $data_xys;
		}

		$result['product_list'] = $Product_Array;
// Product End
// Brand Start
		if(!empty($request->search)){
			$get_brands = $get_brands->orwhere('brands.brand', 'like', '%' . $request->search . '%');
		}

		$get_brands = $get_brands->paginate(80);

		foreach ($get_brands as $kyss_value) {
			$data_xsys['id']        = !empty($kyss_value->id) ? $kyss_value->id : '';
			$data_xsys['product_name']     = !empty($kyss_value->brand) ? $kyss_value->brand : '';	
			$data_xsys['colorrr']     = !empty($kyss_value->product->colorrr) ? $kyss_value->product->colorrr : '';
			$data_xsys['branddd']      = !empty($kyss_value->product->branddd) ? $kyss_value->product->branddd : '';	
				
			$data_xsys['img'] = !empty($kyss_value->product->img) ? $kyss_value->product->img : '';	
			
			$data_xsys['sort_desc']    = !empty($kyss_value->product->sort_desc) ? $kyss_value->product->sort_desc : '';	
			$data_xsys['description']  = !empty($kyss_value->product->description) ? $kyss_value->product->description : '';
			$data_xsys['price']        = !empty($kyss_value->product->price) ? $kyss_value->product->price : '';	


			//$data_xsys['brand_category'] = !empty($kyss_value->category->cat_name) ? $kyss_value->category->cat_name : '';
			// $data_xsys['brand_subcat_name'] = !empty($kyss_value->subcategory->sub_cat_name) ? $kyss_value->subcategory->sub_cat_name : '';	
			
			
			
			// $result[] = $data_xsys;
			$Brand_Array[] = $data_xsys;
		}

		$result['brand_list'] = $Brand_Array;
// Brand End
// color start
		if(!empty($request->search)){
			$get_colors = $get_colors->orwhere('colors.color', 'like', '%' . $request->search . '%');
		}

		$get_colors = $get_colors->paginate(80);

		foreach ($get_colors as $kyss_vaslue) {
			$data_xssys['id']        = !empty($kyss_vaslue->id) ? $kyss_vaslue->id : '';
			$data_xssys['product_name']     = !empty($kyss_vaslue->brand) ? $kyss_vaslue->brand : '';	
			$data_xssys['colorrr']     = !empty($kyss_vaslue->color) ? $kyss_vaslue->color : '';
			$data_xssys['branddd']      = !empty($kyss_vaslue->product->branddd) ? $kyss_vaslue->product->branddd : '';	
				
			$data_xssys['img'] = !empty($kyss_vaslue->product->img) ? $kyss_vaslue->product->img : '';	
			
			$data_xssys['sort_desc']    = !empty($kyss_vaslue->product->sort_desc) ? $kyss_vaslue->product->sort_desc : '';	
			$data_xssys['description']  = !empty($kyss_vaslue->product->description) ? $kyss_vaslue->product->description : '';
			$data_xssys['price']        = !empty($kyss_vaslue->product->price) ? $kyss_vaslue->product->price : '';	

			// $data_xssys['color']     = !empty($kyss_vaslue->color) ? $kyss_vaslue->color : '';	
			// $data_xssys['color_img'] = !empty($kyss_vaslue->product->img) ? $kyss_vaslue->product->img : '';	
			// $data_xssys['cat_name']     = !empty($kyss_vaslue->category->cat_name) ? $kyss_vaslue->category->cat_name : '';	
			
			// $result[] = $data_xssys;
			$Colors_Array[] = $data_xssys;
		}

		$result['color_list'] = $Colors_Array;
// color end		

		$json['status']  = 1;
		$json['message'] = 'All list loaded successfully.';
		$json['result']  = $result;
		echo json_encode($json);

	}


		
}