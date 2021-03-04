<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Slider;

class SliderController extends Controller
{
    public function slider_list(Request $request)
    {
    	$getrecord = Slider::orderBy('id', 'desc');
    	
    	if (!empty($request->id)) {
			$getrecord = $getrecord->where('id', '=', $request->id);
		}

		if (!empty($request->slider_name)) {
			$getrecord = $getrecord->where('slider_name', 'like', '%' . $request->slider_name . '%');
		}

    	// Search Box End
    	$getrecord = $getrecord->paginate(40);
    	$data['getrecord'] = $getrecord;
    	$data['meta_title'] = 'Slider List';
    	return view('backend.slider.list', $data);
    }

    public function slider_add(Request $request)
    {
    	$data['meta_title'] = "Add Slider";
    	return view('backend.slider.add', $data);
    }

    public function slider_insert(Request $request)
    {
        $slider_insert = request()->validate([
            'slider_name'      => 'required',
            'slider_image' => 'required|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($request->hasFile('slider_image')) {
            $slider_image = $request->file('slider_image');
            $no = rand(1111,9999);
            $image_name = time().$no.'.jpg';
            $i = $slider_image->move(public_path('images/slider'), $image_name);
            $cat = new Slider([
                        'slider_name'      =>  $request->get('slider_name'),
                        'slider_image'            =>  $image_name,
                    ]);
                    $cat->save();
            } 
        return redirect('admin/slider')->with('success', 'Record created Successfully!');
    }

    public function slider_edit($id){
        $data['getslider'] = Slider::find($id);
        $data['meta_title'] = "Edit Slider";
        return view('backend.slider.edit', $data);
    }

    public function slider_update($id, Request $request)
    {
        $validated = $request->validate([
            'slider_name'         => 'required',
        ]);
            $slider_update = Slider::find($id);
            $slider_update->fill($validated);  

        if ($request->hasFile('slider_image')) {
            $slider_image = $request->file('slider_image');
            $no = rand(1111,9999);
            $image_name = time().$no.'.jpg';
            $i = $slider_image->move(public_path('images/slider'), $image_name);
            $slider_update->slider_image = $image_name;
        } 
            // dd($slider_update);
        $slider_update->save();

        return redirect('admin/slider')->with('warning', 'Record updated Successfully!');
    }

    public function slider_delete($id)
    {
        $getrecord = Slider::find($id);
        $getrecord->delete();

        return redirect('admin/slider')->with('error', 'Record deleted Successfully!');
    }


}
