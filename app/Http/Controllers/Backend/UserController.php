<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\User;
use Hash;

class UserController extends Controller
{
    public function user_list(Request $request)
    {
    	$getrecord = User::orderBy('id', 'desc')->where('is_delete', '=', 0);
        // $getrecord = User::orderBy('id', 'desc')->whereIn('is_admin',  array('1','2'))->where('is_delete','=',0);
    	// Search Box Start

        // $getrecord = Product::orderBy('id', 'desc')->select('products.*');
        // $getrecord = $getrecord->join('categories', 'products.cat_id', '=', 'categories.id');
    	
    	if (!empty($request->id)) {
			$getrecord = $getrecord->where('id', '=', $request->id);
		}

		if (!empty($request->fullname)) {
			$getrecord = $getrecord->where('fullname', 'like', '%' . $request->fullname . '%');
		}

		if (!empty($request->email)){
			$getrecord = $getrecord->where('email', 'like', '%' . $request->email . '%');
		}
    	// Search Box End
    	$getrecord = $getrecord->paginate(40);
    	$data['getrecord'] = $getrecord;
    	$data['meta_title'] = 'User List';
    	return view('backend.user.list', $data);
    }

    public function user_add(Request $request)
    {
    	$data['meta_title'] = "Add User";
    	return view('backend.user.add', $data);
    }

    public function user_insert(Request $request)
    {
        $user_insert = request()->validate([
            'email'         => 'required|unique:users',
            'password'      => 'required',
            // 'username'      => 'required|unique:users',
            'fullname'      => 'required|unique:users',
        ]);

        $user_insert = new User;
        // $user_insert->username = strtolower($request->username);
        $user_insert->fullname = strtolower($request->fullname);
        $user_insert->password = Hash::make($request->password);
        $user_insert->email    = $request->email;
        $user_insert->status   = $request->status;
        $user_insert->is_admin = $request->is_admin;
        $user_insert->save();
        return redirect('admin/user')->with('success', 'Record created Successfully!');
    }

    public function user_edit($id){
        $data['getuser'] = User::find($id);
        $data['meta_title'] = "Edit User";
        return view('backend.user.edit', $data);
    }

    public function user_update($id, Request $request)
    {
        $user_update = User::find($id);
        if(!empty($request->password)){
            $user_update->password = Hash::make($request->password);
        }
        // $user_update->username   = strtolower($request->username);
        $user_update->fullname   = strtolower($request->fullname);
        $user_update->email      = $request->email;
        $user_update->is_admin   = $request->is_admin;
        $user_update->status     = $request->status;
        $user_update->save();
        return redirect('admin/user')->with('warning', 'Record updated Successfully!');
    }

    public function user_view($id){
        $data['getuser'] = User::find($id);
        $data['meta_title'] = "View User";
        return view('backend.user.view', $data);
    }

    public function user_delete($id)
    {
        $data['getuser'] = User::find($id);
        $data['meta_title'] = "Delete User";
        // dd($data['getuser']);
        if(!($data['getuser']->is_delete == '1'))
        {
            $userDelete = $data['getuser']->update(['is_delete'=>1]);
        }
        return redirect('admin/user')->with('error', 'Record deleted Successfully!');
    }

}