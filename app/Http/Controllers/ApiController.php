<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Models\Favourites;
use Hash;
use Validator;
use Auth;
use Str;
use File;
use DB;

class ApiController extends Controller
{
    public $token;

	public function __construct(Request $request) {
		
		$this->token = !empty($request->header('token'))?$request->header('token'):'';
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


    
   


    

}