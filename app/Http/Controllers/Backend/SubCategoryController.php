<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Sub_Category;
use App\Models\Category;

class SubCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $getrecord = Sub_Category::orderBy('id', 'desc')->select('sub_categories.*');
        $getrecord = $getrecord->join('categories', 'sub_categories.cat_id', '=', 'categories.id');
        // $getrecord = $getrecord->join('users', 'sub_categories.user_id', '=', 'users.id');

    	if (!empty($request->id)) {
			$getrecord = $getrecord->where('sub_categories.id', '=', $request->id);
		}

        if (!empty($request->cat_name)) {
			$getrecord = $getrecord->where('cat_name', 'like', '%' . $request->cat_name . '%');
		}

		if (!empty($request->sub_cat_name)) {
			$getrecord = $getrecord->where('sub_cat_name', 'like', '%' . $request->sub_cat_name . '%');
		}
    	// Search Box End
    	$getrecord = $getrecord->paginate(40);
    	$data['getrecord'] = $getrecord;
    	$data['meta_title'] = 'Sub Category List';
    	return view('backend.subcategory.list', $data); 
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $category = Category::get();
        $data['category'] = $category;
        $data['meta_title'] = "Add Sub Category";
    	return view('backend.subcategory.add', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $category_insert = request()->validate([
            'cat_id'         => 'required',
            'sub_cat_name'         => 'required',
        ]);
           
        $category = Category::get();
        $cat_id = $request->input('cat_id');

        $category_insert = new Sub_Category;
        $category_insert->sub_cat_name    = $request->sub_cat_name;
        $category_insert->cat_id = $cat_id;
        $category_insert->save();

        return redirect('admin/subcategory')->with('success', 'Sub Category added Successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data['getsubcategory'] = Sub_Category::find($id);
        $data['meta_title'] = "view Sub Category";
        return view('backend.subcategory.view', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['getcategory'] = Category::get();
        $data['getsubcategory'] = Sub_Category::with('category')->find($id);
        $data['meta_title'] = "Edit Sub Category";
        return view('backend.subcategory.edit', $data);
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
            'cat_id'         => 'required',
            'sub_cat_name'      => 'required',
        ]);
        $category = Category::get();
        $subcategory = Sub_Category::with('category')->find($id);
        
        $subcategory->fill($validated);        
        $subcategory->save();
        return redirect('admin/subcategory')->with('warning', 'Record updated Successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function subcategory_delete($id)
    {
        $getrecord = Sub_Category::find($id);
        $getrecord->delete();
        return redirect('admin/subcategory')->with('error', 'Record deleted Successfully!');
    }
}
