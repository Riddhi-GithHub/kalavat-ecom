<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\address;
use App\User;
use Validator;

class AddressController extends BaseController
{

    // --------- using base controller ----start-------

   // retrive address by user id
    public function address_list_old_api(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'user_id' => 'required',
        ]);

        $user = User::find($request->input('user_id'));
        $address = address::where('user_id',$request->input('user_id'))->get();

        if(!empty($user)){
            if($validator->fails()){
                return $this->sendError('Validation Error.', $validator->errors()); 
                }elseif(!empty($address->count() > 0)){
                    return $this->sendResponse($address,'user address retrieved successfully.');
                }
                else{
                    return $this->sendError('addres not found.'); 
                } 
            }
        else{
            return $this->sendError('user not found.', $validator->errors()); 
        }
    }

    public function add_address(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'user_id' => 'required',
            'address' => 'required',
            'city' => 'required|string',
            'state' => 'required|string',
            'zip_code' => 'required|min:6|max:6',
            'contry' => 'required|string',
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }

        $user = User::find($request->input('user_id'));

            if(!empty($user)){
                if (!empty($user->otp_verify == 1)) {
                    $address = address::create($request->all());
                    $address->user_id = $input['user_id'];
                    $address->address = $input['address'];
                    $address->city = $input['city'];
                    $address->state = $input['state'];
                    $address->zip_code = $input['zip_code'];
                    $address->contry = $input['contry'];
                    $address->save();
                    return $this->sendResponse($address->toArray(), 'User address add successfully.');
                }
                else {
                    return $this->sendErrors('user not login');  
                }
            }
        else {
            return $this->sendErrors('user not found');  
        }
    }

    public function edit_address(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'address_id' => 'required',
            'user_id' => 'required',
            'address' => 'required',
            'city' => 'required|string',
            'state' => 'required|string',
            'zip_code' => 'required|min:6|max:6',
            'contry' => 'required|string',
        ]);
        
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }
        $address = address::find($request->address_id);
        // if(!empty($user)){
            if (!empty($address)) {
                $address->user_id = $input['user_id'];
                $address->address = $input['address'];
                $address->city = $input['city'];
                $address->state = $input['state'];
                $address->zip_code = $input['zip_code'];
                $address->contry = $input['contry'];
                $address->update();
                return $this->sendResponse($address->toArray(), 'User address updated successfully.');
            }
        else {
            return $this->sendErrors('user address not found');  
        }
    }

    public function delete_address(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input,[
            'address_id' => 'required',
            'user_id' => 'required',
            ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }
        
        $user = User::find($request->input('user_id'));
        $address = address::where('address_id',$request->address_id)->where('user_id',$request->user_id)->delete();
          
        if(!empty($user)){
            if($validator->fails()){
                return $this->sendError('Validation Error.', $validator->errors()); 
            }elseif(!empty($address)){
                return $this->sendResponse($address,'user address deleted successfully.');
            }
            else{
                return $this->sendError('address not found.'); 
            } 
        }
        else{
            return $this->sendError('user not found.'); 
        }
    }

    // --------- using base controller ----finish-------




    public function Address_Add(Request $request)
    {
        $user = User::find($request->user_id);

        if(!empty($user)) {
            $address = address::create($request->all());
            $address->save();
            $json['success'] = 1;
            $json['message'] = 'Address add Successfully.';
            $json['user_address'] = $address;
        }

        else{
            $json['success'] = 0;
            $json['message'] = 'User not found.';
        }

 	    echo json_encode($json);
        //$address->amount  = trim($request->amount);
	}

    public function Address_Edit(Request $request)
    {
        // $address_update = address::find($request->address_id);
        $address_update = User::find($request->input('user_id'));

        if(!empty($address_update)) {
            // $address_update->address_id  = trim($request->address_id);
            // $address_update->user_id  = trim($request->user_id);
            $address_update->fullname  = trim($request->fullname);
            $address_update->username  = trim($request->fullname);
            $address_update->address  = trim($request->address);
            $address_update->city  = trim($request->city);
            $address_update->state  = trim($request->state);
            $address_update->zip_code  = trim($request->zip_code);
            $address_update->contry  = trim($request->contry);
            $address_update->save();

            $json['success'] = 1;
            $json['message'] = 'Address update Successfully.';
            $json['user_address'] = $address_update;
        }
        else{
            $json['success'] = 0;
            $json['message'] = 'User not found.';
        }

 	    echo json_encode($json);
        //$address->amount  = trim($request->amount);
	}

    public function Address_List(Request $request)
	{
	    $result  = array();
		// $getresult  = Favourites::with('user','product')->where('user_id', '=' ,$request->user_id)->where('product_id', '=' ,$request->product_id)->get();
		$getresult  = address::where('user_id', '=' ,$request->user_id)->get();

        if(!empty($getresult->count() > 0)){
            $json['success'] = 1;
            $json['message'] = 'Address list loaded Successfully.';
            $json['user_address'] = $getresult;
        }
        else{
            $json['success'] = 0;
            $json['message'] = 'Address not found.';
        }

 	    echo json_encode($json);
	}


    
    // public function Address_Delete(Type $var = null)
    // {
    //     $result  = array();
	// 	$getresult  = address::where('user_id', '=' ,$request->user_id)->get();

    //     if(!empty($getresult->count() > 0)){
    //         $json['status'] = 1;
    //         $json['message'] = 'Address list loaded Successfully.';
    //         $json['user_address'] = $getresult;
    //     }
    //     else{
    //         $json['status'] = 0;
    //         $json['message'] = 'Address not found.';
    //     }

 	//     echo json_encode($json);
    // }

}
