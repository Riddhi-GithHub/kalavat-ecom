<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\address;
use App\User;
use Validator;

class AddressController extends BaseController
{
   // retrive address by user id
    public function address_list(Request $request)
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

}
