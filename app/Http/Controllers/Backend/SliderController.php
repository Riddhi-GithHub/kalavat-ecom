<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Slider;
use App\Models\Category;
use App\Models\Sub_Category;
use App\Models\Product;

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
        $category = Category::get();
        $subcategory = Sub_Category::get();
        $product = Product::get();
        $data['category'] = $category;
        $data['subcategory'] = $subcategory;
        $data['product'] = $product;
    	$data['meta_title'] = "Add Slider";
    	return view('backend.slider.add', $data);
    }

    public function slider_insert(Request $request)
    {
        $input = request()->validate([
            'slider_name'      => 'required',
            'type'      => 'required',
            'type_id'      => 'required',
            'slider_image' => 'required|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // dd($request->type);
        // dd($request->type_id);

        if ($request->hasFile('slider_image')) {
            $slider_image = $request->file('slider_image');
            $no = rand(1111,9999);
            $image_name = time().$no.'.jpg';
            $i = $slider_image->move(public_path('images/slider'), $image_name);
            $slider_insert = new Slider([
                        'slider_image'     =>  $image_name,
                        'offer'            => $request->offer,
                        'discount'         => $request->discount,
                        'slider_name'      => $request->slider_name,
                        'type'             => $request->type,
                        'type_id'          => $request->type_id,
                    ]);
            $slider_insert->save();
        } 
        return redirect('admin/slider')->with('success', 'Record created Successfully!');
    }

    public function slider_edit($id){
        $category = Category::get();
        $subcategory = Sub_Category::get();
        $product = Product::get();
        $data['category'] = $category;
        $data['subcategory'] = $subcategory;
        $data['product'] = $product;

        $data['getslider'] = Slider::find($id);
        $data['meta_title'] = "Edit Slider";
        return view('backend.slider.edit', $data);
    }

    public function slider_update($id, Request $request)
    {
        $validated = $request->validate([
            'slider_name'         => 'required',
            'type'      => 'required',
            'type_id'      => 'required',
        ]);
            $slider_update = Slider::find($id);
            $slider_update->fill($validated);  
            $slider_update->offer = $request->offer;
            $slider_update->discount = $request->discount;

        if ($request->hasFile('slider_image')) {
            //    dd(!empty($slider_update->slider_image));
            if (!empty($slider_update->slider_image) && file_exists(public_path('images/slider/'.$slider_update->image)))
            {
                unlink(public_path('images/slider/'.$slider_update->slider_image));
            }

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

        //    dd(file_exists(public_path('images/slider/'.$getrecord->image)));
        if (!empty($getrecord->slider_image) && file_exists(public_path('images/slider/'.$getrecord->image)))
        {
            unlink(public_path('images/slider/'.$getrecord->slider_image));
        }
        $getrecord->delete();   
        return redirect('admin/slider')->with('error', 'Record deleted Successfully!');
    }


}
