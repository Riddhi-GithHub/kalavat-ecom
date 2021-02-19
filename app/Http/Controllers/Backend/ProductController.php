<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\category;
use App\Models\product_images;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    	$getrecord = Product::orderBy('id', 'desc');
        // $getrecord = category::orderBy('id', 'desc');
        // $getrecord = Product::with('category')->latest()->get();
    	
    	if (!empty($request->id)) {
			$getrecord = $getrecord->where('id', '=', $request->id);
		}

		if (!empty($request->product_name)) {
			$getrecord = $getrecord->where('product_name', 'like', '%' . $request->product_name . '%');
		}
	
    	// Search Box End
    	$getrecord = $getrecord->paginate(40);
    	$data['getrecord'] = $getrecord;
    	$data['meta_title'] = 'Product List';
    	return view('backend.product.list', $data);
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
        $data['meta_title'] = "Add product";
    	return view('backend.product.add', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $product_insert = request()->validate([
            'cat_id'         => 'required',
            'product_name'      => 'required',
            'description' => 'required|string|max:2000',
            'price' => 'required|regex:/^[0-9]+(\.[0-9][0-9]?)?$/',
            'quantity' => 'required|integer|min:1',
            'offer' => 'required|integer|min:1',
            'color' => 'required|max:30',
            'size' => 'required|max:30',
            'brand' => 'required|max:30',
            'images' => 'required|max:15000'
        ]);
        
        $category = category::get();
        $cat_id = $request->input('cat_id');

        $product_insert = new Product;
        $product_insert->cat_id = $cat_id;
        $product_insert->product_name = strtolower($request->product_name);
        $product_insert->description    = $request->description;
        $product_insert->price    = $request->price;
        $product_insert->quantity    = $request->quantity;
        $product_insert->offer    = $request->offer;
        $product_insert->color   = $request->color;
        $product_insert->size = $request->size;
        $product_insert->brand = $request->brand;
        $product_insert->save();

        if($request->has('images')) {
            foreach ($request->images as $image) {
                product_images::create([
                    'product_id'        => $product_insert->id,
                    'images'             =>  $image->store('images/product'),
                    ]);
                }
            }

        return redirect('product')->with('success', 'Record created Successfully!'); 
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        dd('show');
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
        $data['getproduct'] = Product::with('category')->find($id);
        $data['getimages'] = Product_images::find($id);
        $data['meta_title'] = "Edit Product";
        return view('backend.product.edit', $data);

        // $category = Category::get();
        // $item = Product::with('category')->find($id);  
        // return view('ProductItem.edit',compact('item','category'));
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
            'product_name'      => 'required',
            'description' => 'required|string|max:2000',
            'price' => 'required|regex:/^[0-9]+(\.[0-9][0-9]?)?$/',
            'quantity' => 'required|integer|min:1',
            'offer' => 'required|integer|min:1',
            'color' => 'required|max:30',
            'size' => 'required|max:30',
            'brand' => 'required|max:30',
            // 'images' => 'required|max:15000'
        ]);
        // $product = Product::find($id);
        $category = category::get();
        $product = Product::with('category')->find($id);
        $product->fill($validated);        
        $product->save();
        return redirect('product')->with('warning', 'Record updated Successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        dd('delete');
    }
}
