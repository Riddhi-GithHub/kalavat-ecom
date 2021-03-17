<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\User;
use App\Models\address;
use App\Models\ContactUs;
use Validator;
use Hash;

class UsersController extends BaseController
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'mobile' => 'required|unique:users',
        ]);
        // $validator =  $request['mobile'] = $request->mobile;
        
        if($validator->fails()){
            return $this->sendErrors('Mobile allready taken');       
        }

        $input = $request->all();
        $otp = rand(1111,9999);
        $user = User::create($input);
        $user['mobile'] =  $user->mobile;
        $user['otp'] =  9999;
        $user['token'] =  $user->token;
        // $user['token'] = 'wedfghjklfghjkl456f435f4ds35f4';
        $user->save();

        return $this->sendResponse($user, 'User register successfully.');
    }

    public function verification_otp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'mobile' => 'required|min:10|max:10',
            'otp' => 'required|min:4|max:4',
        ]);

        $user = User::where('mobile', '=', ($request->mobile))->where('otp', '=', ($request->otp))->first();
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors()); 
        }elseif (!empty($user)) {
                if (!empty($user)) {
                    $user->otp_verify = 1;
                    $user->update();
                    return $this->sendResponse($user, 'Login successfully!');
                } else {
                    return $this->sendError('Otp not Verified.');  
                }
            } else {
                return $this->sendError('Mobile number and otp not match.'); 
        }
    }

    public function resend_mobile_otp(Request $request) 
    {
        $validator = Validator::make($request->all(), [
            'mobile' => 'required|min:10|max:10',
        ]);

        $user = User::where('mobile', '=', trim($request->mobile))->first();
        $otp = rand(1111,9999);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator); 
        }elseif(!empty($user)) {
            $user->otp = 9999;
            $user->update();
            return $this->sendResponse($user->otp, 'OTP resent successfully!');
            }
        else {
            return $this->sendError('Mobile number not found.');
        }
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'mobile' => 'required|min:10|max:10',
        ]);

        $user = User::where('mobile', '=', ($request->mobile))->first();
        $otp = rand(1111,9999);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors()); 
        }elseif (!empty($user)) {
                if (!empty($user)) {
                    $user->otp = 9999;
                    $user->update();
                    // return $this->sendResponse($user, 'Login successfully!');
                    return $this->sendResponse($user, 'OTP sent successfully!');
                } else {
                    return $this->sendError('Otp not Verified.');  
                }
            } else {
                return $this->sendError('User not exists.'); 
        }
    }

    public function edit_account(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'id' => 'required',
            'fullname' => 'required',
            'email' => 'required',
            'password' => 'required|min:6',
            'mobile' => 'required',
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }

        $user = User::find($request->id);
        // if(!empty($user)){
            if (!empty($user->otp_verify == 2)) {
                $user->fullname = $input['fullname'];
                $user->username = $input['fullname'];
                $user->email = $input['email'];
                $user->mobile = $input['mobile'];
                $user->password = Hash::make($input['password']);

                $user->update();
                return $this->sendResponse($user->toArray(), 'User updated successfully.');
            }
        else {
            return $this->sendError('user not login');  
        }
    }

    public function add_contact(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'user_id' => 'required',
            'title' => 'required|string',
            'description' => 'required|string',
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }
        $user = User::find($request->input('user_id'));
        if(!empty($user)){
            $contact = ContactUs::create($request->all());
            $contact->user_id = $input['user_id'];
            $contact->title = $input['title'];
            $contact->description = $input['description'];
            $contact->save();
            return $this->sendResponse($contact->toArray(), 'contact add successfully.');
        }
        else {
            return $this->sendError('user not found');  
        }
    }

    public function add_account_old(Request $request)  // store address in address table
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'fullname' => 'required',
            'email' => 'required|unique:users',
            'mobile' => 'required',
            'dob' => 'required|date_format:d/m/Y',
            'gender' => 'required',
            'image' => 'required',

            'address' => 'required',
            'city' => 'required',
            'state' => 'required',
            'zip_code' => 'required|min:6|max:6',
            'contry' => 'required',
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }

        $user = User::where('mobile', '=', ($request->mobile))->first();
        // dd($user); 
            if (!empty($user->otp_verify == 1)) {
                $user->fullname = $input['fullname'];
                $user->username = $input['fullname'];
                $user->email = $input['email'];
                $user->gender = $input['gender'];
                $user->mobile = $input['mobile'];
                $user->dob = $input['dob'];
                $user->otp_verify = 2;
                if ($request->hasFile('image')) {
                    $image = $request->file('image');
                    $no = rand(1111,9999);
                    $image_name = time().$no.'.jpg';
                    $i = $image->move(public_path('images/user'), $image_name);
                    $user->image = $image_name;
                } 
                $user->save();
                $address = address::create($request->all());
                $address->user_id = $user->id;
                $address->save();

                $data = User::with('address')->where('mobile', '=', ($request->mobile))->first();
                return $this->sendResponse($data->toArray(), 'User add successfully.');
            }
        else {
            return $this->sendError('user not login');  
        }
    }
    
    // store address in users table
    public function add_account(Request $request)
    {
        $input = $request->all();
        // $validator = Validator::make($input, [
            // 'fullname' => 'required',    
            // 'email' => 'required|unique:users',
            // 'mobile' => 'required',
            // 'dob' => 'required|date_format:d/m/Y',
            // 'gender' => 'required',
            // 'image' => 'required',
            // 'address' => 'required',
            // 'city' => 'required',
            // 'state' => 'required',   
            // 'zip_code' => 'required|min:6|max:6',
            // 'contry' => 'required',
            // 'password' => 'required|min:6'
        // ]);
        // dd(!empty($validator));

        // if($validator->fails()){
        //     return $this->sendError('Validation Error.', $validator->errors());       
        // }



        $user = User::where('mobile', '=', ($request->mobile))->first();

        // dd(empty($user));
        if (!empty($request->mobile && $request->email)){
            if(!empty($user)){
                $email = User::where('email', '=', ($request->email))->count();
                    // dd(empty($email));
                if(empty($email)){
                    if (!empty($user->otp_verify != 0)) {
                            $user->fullname = $input['fullname'];
                            $user->username = $input['fullname'];
                            $user->email = $input['email'];
                            $user->address  = $input['address'];
                            $user->city  = $input['city'];
                            $user->state  = $input['state'];
                            // $user->zip_code  = $input['zip_code'];      // required 
                            $user->zip_code  = $request->zip_code;          // is empty working
                            $user->contry  = $input['contry'];
                            $user->gender = $input['gender'];
                            $user->mobile = $input['mobile'];
                            $user->dob = $input['dob'];
                            $user->otp_verify = 2;
                            // $user->password = Hash::make($input['password']);
                            $user->password = Hash::make($request->password);

                            if ($request->hasFile('image')) {
                                $image = $request->file('image');
                                $no = rand(1111,9999);
                                $image_name = time().$no.'.jpg';
                                $i = $image->move(public_path('images/user'), $image_name);
                                $user->image = $image_name;
                            } 
                            $user->save();
                            // $data = User::where('mobile', '=', ($request->mobile))->first();
                            return $this->sendResponse($user,'User add Successfully.');
                        }
                    else {
                        return $this->sendError('User not login');  
                    }
                }
                else{
                    return $this->sendError('Email allready exist.'); 
                }
            }
            else{
                return $this->sendError('Mobile not Match'); 
            }
        }
        else{
            return $this->sendError('Mobile and Email Required.'); 
        }
    }

    public function forgot_password_old(Request $request)
	{
		$input = $request->all();
		if (!empty($request->email)) {
			// dd($request->mobile);
			$otp = rand(1111,9999);
			// $otp = 9999;
            $user = User::where('email', '=', trim($request->email))->first();
		     if (!empty($user)) {
				$user->otp = 9999;

				$resetLink = '';
				if (!($input['email'])) {
					$resetLink = env(
						'ADMIN_LINK');
				} else {
					$resetLink = $this->getProtocol().'http://localhost/laravel/kalavat/public'.env('MAIN_DOMAIN');
				}
				dd($resetLink);
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
}
