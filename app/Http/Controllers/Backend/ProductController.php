<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Sub_Category;
use App\Models\product_images;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request)
    {
        $id = Product::pluck('id');
		foreach ($id as $d) {
			$rating = Rating::with('restaurant')->where('ratings.rating_restaurant_id',$d)->count('ratings.rating_restaurant_id');
		}


    	//$getrecord = Product::orderBy('id', 'desc');
        $getrecord = Product::orderBy('id', 'desc')->select('products.*');
        $getrecord = $getrecord->join('categories', 'products.cat_id', '=', 'categories.id');
    	
    	if (!empty($request->id)) {
			$getrecord = $getrecord->where('products.id', '=', $request->id);
		}
		
        if (!empty($request->cat_name)) {
			$getrecord = $getrecord->where('cat_name', 'like', '%' . $request->cat_name . '%');
		}

		if (!empty($request->product_name)) {
			$getrecord = $getrecord->where('product_name', 'like', '%' . $request->product_name . '%');
		}
        if (!empty($request->price)) {
			$getrecord = $getrecord->where('price', '=', $request->price);
		}
	
    	// Search Box End
    	$getrecord = $getrecord->paginate(40);
    	$data['getrecord'] = $getrecord;
    	$data['meta_title'] = 'Product List';
    	return view('backend.product.list', $data);
    }



    public function index_backup(Request $request)
    {

    	//$getrecord = Product::orderBy('id', 'desc');
        $getrecord = Product::orderBy('id', 'desc')->select('products.*');
        $getrecord = $getrecord->join('categories', 'products.cat_id', '=', 'categories.id');
    	
    	if (!empty($request->id)) {
			$getrecord = $getrecord->where('products.id', '=', $request->id);
		}
		
        if (!empty($request->cat_name)) {
			$getrecord = $getrecord->where('cat_name', 'like', '%' . $request->cat_name . '%');
		}

		if (!empty($request->product_name)) {
			$getrecord = $getrecord->where('product_name', 'like', '%' . $request->product_name . '%');
		}
        if (!empty($request->price)) {
			$getrecord = $getrecord->where('price', '=', $request->price);
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
    public function create(Request $request)
    {
        $category = Category::get();
        $subcategory = Sub_Category::get();
        $data['category'] = $category;
        $data['subcategory'] = $subcategory;
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
            'sub_cat_id'         => 'required',
            'product_name'      => 'required',
            'description' => 'required|string|max:2000',
            'price' => 'required|regex:/^[0-9]+(\.[0-9][0-9]?)?$/',
            'quantity' => 'required|integer|min:1',
            'offer' => 'required|integer|min:1',
            'color' => 'required|max:30',
            'size' => 'required|max:30',
            'brand' => 'required|max:30',
            'images' => 'required|max:15000'
            //   'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        
        $category = Category::get();
        $cat_id = $request->input('cat_id');

        $category = Sub_Category::get();
        $sub_cat_id = $request->input('sub_cat_id');
        
         foreach($request->brand as $b){
             $ba[] = $b;
         }
        // $brand[] =  $request->brand;
        $product_insert = new Product;
        $product_insert->cat_id = $cat_id;
        $product_insert->sub_cat_id = $sub_cat_id;
        $product_insert->product_name = strtolower($request->product_name);
        $product_insert->description    = $request->description;
        $product_insert->price    = $request->price;
        $product_insert->quantity    = $request->quantity;
        $product_insert->offer    = $request->offer;
        $product_insert->color   = $request->color;
        $product_insert->size = $request->size;
        $product_insert['brand'] = $b;

        // $brand = $request->input('brand');
        // dd($product_insert);
        $product_insert->save();

        // foreach($request->brand as $b){
        //     $ba[] = $b;
        // $product =  Product::create([
        //     'cat_id'        => $cat_id,
        //     'sub_cat_id'        => $sub_cat_id,
        //     'offer'        => $request->offer,
        //     'size'        => $request->size,
        //     'brand'        => $ba,
        //     ]);
        // }

        if($request->hasfile('images')) {
            foreach($request->file('images') as $file){
                    // $image_name = time().'-'.$file->getClientOriginalName();
                    $no = rand(1111,9999);
                    $image_name = time().$no.'.jpg';
                    $file->move(public_path('images/product'), $image_name);
                    // $input['images']=json_encode($data);
                    $data[] = $image_name;
                    $image =  product_images::create([
                        'product_id'        => $product_insert->id,
                        'images'             => $image_name,
                        ]);
                    }
                }
            // store single image
            $product = Product::find($product_insert->id);
            $product->img = $data[0];
            $product->save();
        return redirect('admin/product')->with('success', 'Record created Successfully!'); 
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data['getproduct'] = Product::with('images')->find($id);
        $data['meta_title'] = "View product";
        return view('backend.product.view', $data);
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
        $data['getimages'] = Product_images::where('product_id',$id)->get();
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
        $category = Category::get();
        $product = Product::with('category')->find($id);
            
            if($request->hasfile('images')) {
                $images_update = Product_images::where('product_id',$id)->delete();
                // dd($images_update);
                foreach($request->file('images') as $file){
                    // $image_name = time().'-'.$file->getClientOriginalName();
                    $no = rand(1111,9999);
                    $image_name = time().$no.'.jpg';
                    $file->move(public_path('images/product'), $image_name);
                    // $input['images']=json_encode($data);
                    $data[] = $image_name;
                        $images_new =  product_images::create([
                            'product_id'        => $id,
                            'images'             => $image_name,
                            ]);
                    }
                    $images_new->save();
                    // store single image
                    $product = Product::find($id);
                    $product->img = $data[0];
                    $product->save();
                }
        
        $product->fill($validated);        
        $product->save();
        return redirect('admin/product')->with('warning', 'Record updated Successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function destroy($id)
    // {
    //     $data['getproduct'] = Product::with('images')->find($id);
    //     $data['meta_title'] = "Delete category";
    //     $getrecord = Product::find($id);
    //     dd($getrecord);
    //     $getrecord->delete();
    //     // $data['getcategory']->delete();
    //     return redirect('admin/product')->with('error', 'Record deleted Successfully!');
    // }

    public function product_delete($id)
    {
        $getrecord = Product::with('images')->find($id);
        $getrecord->delete();
        return redirect('admin/product')->with('error', 'Record deleted Successfully!');
    }
}
