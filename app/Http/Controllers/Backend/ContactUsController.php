<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ContactUs;


class ContactUsController extends Controller
{
    public function contact_us_list(Request $request)
    {
    	$getrecord = ContactUs::orderBy('id', 'desc');
        // $getrecord = User::orderBy('id', 'desc')->whereIn('is_admin',  array('1','2'))->where('is_delete','=',0);
    	// Search Box Start
    	
    	if (!empty($request->id)) {
			$getrecord = $getrecord->where('id', '=', $request->id);
		}

		if (!empty($request->title)) {
			$getrecord = $getrecord->where('title', 'like', '%' . $request->title . '%');
		}

		if (!empty($request->description)){
			$getrecord = $getrecord->where('description', 'like', '%' . $request->description . '%');
		}
    	// Search Box End
    	$getrecord = $getrecord->paginate(40);
    	 $data['getrecord'] = $getrecord;
   		 $data['meta_title'] = 'Contact Us List';
    	return view('backend.contact_us.list', $data);
    }

    public function contact_us_delete($id)
    {
    	$getrecord = ContactUs::find($id);
        $getrecord->delete();
        return redirect('admin/contact_us')->with('error', 'Record successfully deleted!');
    }

   

}