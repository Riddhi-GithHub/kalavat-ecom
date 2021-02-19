<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\category;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $getrecord = category::orderBy('id', 'desc');
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
        ]);

        $category = new category;
        $category->cat_name = strtolower($request->cat_name);
        $category->save();
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
        $data['getcategory'] = category::find($id);
        $data['meta_title'] = "View category";
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
        $data['getcategory'] = category::find($id);
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
        $category_update = category::find($id);
       
        $category_update->cat_name   = strtolower($request->cat_name);
        $category_update->save();
        return redirect('admin/category')->with('warning', 'Record updated Successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data['getcategory'] = category::find($id);
        $data['meta_title'] = "Delete category";
        // dd($data['getcategory']);
        $data['getcategory']->delete();
        
        return redirect('admin/category')->with('error', 'Record deleted Successfully!');
    }
}
