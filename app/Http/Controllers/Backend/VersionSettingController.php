<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Version_Setting;


class VersionSettingController extends Controller
{
    public function versionsetting(Request $request)
    {
        $getrecord = Version_Setting::orderBy('id', 'desc');
    	
    	// Search Box End
    	$getrecord = $getrecord->paginate(40);
    	$data['getrecord'] = $getrecord;
    	$data['meta_title'] = 'App Version';
    	return view('backend.version.list', $data);
    }

    public function versionsetting_edit($id){
        $data['getuser'] = Version_Setting::find($id);
        $data['meta_title'] = "Edit App Version";
        return view('backend.version.edit', $data);
    }

    public function versionsetting_update($id, Request $request)
    {
        $version_update = Version_Setting::find($id);
     
        $version_update->app_version      = $request->app_version;
        $version_update->save();
        return redirect('admin/versionsetting')->with('warning', 'Record updated Successfully!');
    }

}
