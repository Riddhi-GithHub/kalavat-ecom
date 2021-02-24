<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Category;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $getrecord = Category::orderBy('id', 'desc');
    	// Search Box Start
    	
    	if (!empty($request->id)) {
			$getrecord = $getrecord->where('id', '=', $request->id);
		}

		if (!empty($request->cat_name)) {
			$getrecord = $getrecord->where('cat_name', 'like', '%' . $request->cat_name . '%');
		}

    	// Search Box End
    	$getrecord = $getrecord->paginate(40);
    	$data['getrecord'] = $getrecord;
    	$data['meta_title'] = 'Category List';
    	return view('backend.category.list', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['meta_title'] = "Add Category";
    	return view('backend.category.add', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $category = request()->validate([
            'cat_name'         => 'required',
            'image' => 'required|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $no = rand(1111,9999);
                $image_name = time().$no.'.jpg';
                $i = $image->move(public_path('images/category'), $image_name);
                $cat = new Category([
                            'cat_name'      =>  $request->get('cat_name'),
                            'image'            =>  $image_name,
                        ]);
                        $cat->save();
                } 
        return redirect('admin/category')->with('success', 'Category added Successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data['getcategory'] = Category::find($id);
        $data['meta_title'] = "Category List";
        return view('backend.category.view', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['getcategory'] = Category::find($id);
        $data['meta_title'] = "Edit Category";
        return view('backend.category.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'cat_name'         => 'required',
        ]);
            $category_update = Category::find($id);
            $category_update->fill($validated);  

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $no = rand(1111,9999);
            $image_name = time().$no.'.jpg';
            $i = $image->move(public_path('images/category'), $image_name);
            $category_update->image = $image_name;
        } 
            // dd($category_update);
        $category_update->save();
      
        return redirect('admin/category')->with('warning', 'Record updated Successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function destroy($id)
    // {
    //     $getrecord = Category::find($id);
    //     $getrecord->delete();
    //     return redirect('admin/category')->with('error', 'Record successfully deleted!');
    // }

    public function category_delete($id)
    {
        $getrecord = Category::find($id);
        $getrecord->delete();
        return redirect('admin/category')->with('error', 'Record successfully deleted!');
    }
}
