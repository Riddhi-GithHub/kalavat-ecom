<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

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
}