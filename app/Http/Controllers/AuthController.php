<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\User;
use Hash;

class AuthController extends Controller
{
	public function login(Request $request){

		if (Auth::check()) {
			return redirect('admin/dashboard');
		}
		return view('backend.auth.login');
	}

	public function post_login(Request $request){
		if (Auth::attempt(['email' => $request->email, 'password' => $request->password, 'is_delete' => '0'], true)) {
			if(empty(Auth::user()->status))
			{	
				if(Auth::user()->is_admin == 1 || Auth::user()->is_admin == 2)
				{
					return redirect()->intended('admin/dashboard');		
				}
				else
				{
					Auth::logout();
					return redirect()->back()->with('error', 'Please enter the correct credentials');	
				}
			}
			else
			{
				Auth::logout();
				return redirect()->back()->with('error', 'Please enter the correct credentials');	
			}
		} else {
			return redirect()->back()->with('error', 'Please enter the correct credentials');
		}

	}

	public function logout(Request $request)
	{
		Auth::logout();
		return redirect(url('admin/login'));
	}

	public function change_password(Request $request)
	{
		$u_id  = Auth::user()->id;
		$user = User::find($u_id);
		return view('backend.auth.changePassword',['user'=>$user]);
	}
	public function store_password(Request $request)
	{
		$request->validate([
			'fullname' => ['required'],
			'email' => ['required'],
			'new_password' => ['required'],
			'new_confirm_password' => ['same:new_password'],
			]);

		$u_id  = Auth::user()->id;
		$user = User::find($u_id);
		$user->password=$request->input('password');
		// $user->password=$request->input('new_confirm_password');
		$user->fullname =  $request->input('fullname');
		$user->email =  $request->input('email');
		$user->password =  Hash::make($request->get('new_password'));
		$user->password =  Hash::make($request->get('new_confirm_password'));
		// dd($user);
		$user->save();

		return redirect('admin/logout')->with('success', 'Password Change Successfully!');  
		// return back()->with('message','password change successfully');
	}

}