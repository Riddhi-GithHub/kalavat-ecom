<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Sub_Category;
use App\Models\product_images;
use App\Models\Rating;
use App\Models\Brand;
use App\Models\Color;
use App\Models\Size;
use App\Models\Manufacturing;
use App\Models\ProductDetails;
use App\Models\Sale;
use Illuminate\Support\Facades\Storage;
use DB;

use App\Imports\ProductsImport;
use Maatwebsite\Excel\Facades\Excel;


class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request)
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
        $sale = Sale::get();
        $data['category'] = $category;
        $data['subcategory'] = $subcategory;
        $data['sale'] = $sale;
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
        $input = request()->validate([
            'cat_id'         => 'required',
            'sub_cat_id'         => 'required',
            'product_name'      => 'required',
            'description' => 'required|string|max:2000',
            'price' => 'required|regex:/^[0-9]+(\.[0-9][0-9]?)?$/',
            'quantity' => 'required|integer|min:1',
            'color' => 'required|max:30',
            'size' => 'required|max:30',
            'brand' => 'required|max:30',
            'images' => 'required|max:15000',
            'sort_desc'      => 'required',
            // 'title'      => 'required',
            'address'      => 'required',
            'city'      => 'required|string',
            'state'      => 'required|string',
            'contry'      => 'required|string',
            'zip_code'      => 'required|min:6|max:6',
            'manufacture_by'      => 'required|string',
            'manufacture_date'      => 'required|date_format:m-d-Y',

        ]);

        // dd($product_insert);
            // 'item_model_num'      => 'required',
            // 'offer' => 'integer|min:1',
            //   'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        
        $cat_id = $request->input('cat_id');
        $sub_cat_id = $request->input('sub_cat_id');
        
        //  foreach($request->brand as $b){
        //      $ba[] = $b;
        //  }
        // $brand[] =  $request->brand;

        // dd($product_insert);
        $model_num = rand(1111111111,9999999999);
        $num = 'KL'.$model_num;

        $product_insert = new Product;
        // $product_insert->cat_id = $cat_id;
        $product_insert->cat_id = $request->cat_id;
        $product_insert->sub_cat_id = $request->sub_cat_id;
        $product_insert->sale_id = $request->sale_id;
        $product_insert->product_name = strtolower($request->product_name);
        $product_insert->description    = $request->description;
        $product_insert->price    = $request->price;
        $product_insert->quantity    = $request->quantity;
        $product_insert->offer    = $request->offer;
        $product_insert->sort_desc    = $request->sort_desc;
        $product_insert->size_and_fit    = $request->size_and_fit;
        $product_insert->style_note    = $request->style_note;
        $product_insert->material_and_care    = $request->material_and_care;
        $product_insert->item_model_num    = $num;
        $product_insert->offer    = $request->offer;
        $product_insert->save();

        if($request->color) {
            foreach($request->color as $c){
                $color[] = $c;
                // dd(Color::get());

                $insert_color =  Color::create([
                    'color_cat_id'        => $cat_id,
                    'color_subcat_id'        => $sub_cat_id,
                    'color_product_id'    => $product_insert->id,
                    'color'               => $c,
                    ]);
                    // dd($insert_color);
                }
        }

        if($request->size) {
            foreach($request->size as $s){
                $size[] = $s;
                $insert_size =  Size::create([
                    'size_cat_id'        => $cat_id,
                    'size_subcat_id'     => $sub_cat_id,
                    'size_product_id'    => $product_insert->id,
                    'size'               => $s,
                    ]);
                }
                // dd($size);
        }

        if($request->brand) {
            foreach($request->brand as $b){
                $brand[] = $b;
                $insert_brand =  Brand::create([
                    'brand_cat_id'        => $cat_id,
                    'brand_subcat_id'     => $sub_cat_id,
                    'brand_product_id'    => $product_insert->id,
                    'brand'               => $b,
                    ]);
                }
                // dd($insert_brand);
        }

        if($product_insert->id) {
            // foreach($request->brand as $b){
                $manufacture =  Manufacturing::create([
                    'product_id'        => $product_insert->id,
                    'address'            => $request->address,
                    'city'            => $request->city,
                    'state'            => $request->state,
                    'contry'            => $request->contry,
                    'zip_code'            => $request->zip_code,
                    'manufacture_by'      => $request->manufacture_by,
                    'manufacture_date'    => $request->manufacture_date,
                    ]);
                // }
                // dd($manufacture);
        }

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

        if(!empty($request->option)) {
            foreach ($request->option as $value) {
                if(!empty($value['title'])) {
                    // dd('d');
                    $option = new ProductDetails;
                    $option->product_id = $product_insert->id;
                    // $option->title     = $value->title;
                     $option->title     = !empty($value['title']) ? $value['title'] : '';
                     $option->title_description     = !empty($value['title_description']) ? $value['title_description'] : '';
                    // dd($option);
                     $option->save();
                }
            }
        }

            // store single image on product table
            $product = Product::find($product_insert->id);
            $product->img = $data[0];
            $product->colorrr = $color[0];
            $product->sizess = $size[0];
            $product->branddd = $brand[0];
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
        $data['getcolor'] = Color::where('color_product_id',$id)->get();
        $data['getsize'] = Size::where('size_product_id',$id)->get();
        $data['getbrand'] = Brand::where('brand_product_id',$id)->get();
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
        $data['getsubcategory'] = Sub_Category::get();
        $data['getsale'] = Sale::get();
        $data['getcolor'] = Color::where('color_product_id',$id)->get();
        $data['getsize'] = Size::where('size_product_id',$id)->get();
        $data['getbrand'] = Brand::where('brand_product_id',$id)->get();
        // $data['getproduct'] = Product::with('category','manufacturing','brand','size','color')->find($id);
        $data['getproduct'] = Product::with('category','subcategory','sale','manufacturing')->find($id);
        // dd($data);
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
            'sub_cat_id'         => 'required',
            'product_name'      => 'required',
            'description' => 'required|string|max:2000',
            'price' => 'required|regex:/^[0-9]+(\.[0-9][0-9]?)?$/',
            'quantity' => 'required|integer|min:1',
            'sort_desc'      => 'required',

            'color' => 'required|max:30',
            'size' => 'required|max:30',
            'brand' => 'required|max:30',
            'address'      => 'required',
            'city'      => 'required|string',
            'state'      => 'required|string',
            'contry'      => 'required|string',
            'zip_code'      => 'required|min:6|max:6',
            // 'manufacture_by'      => 'required|string',
            'manufacture_date'      => 'required|date_format:m-d-Y',
            // 'images' => 'required|max:15000'
        ]);
        // dd($validated);

        $category = Category::get();
        $category = Sub_Category::get();
        $product = Product::with('category','subcategory')->find($id);

            $manufacture = Manufacturing::where('product_id',$id)->first();
            $manufacture->product_id = $id;
            $manufacture->address = $request->address;
            $manufacture->city = $request->city;
            $manufacture->state = $request->state;
            $manufacture->contry = $request->contry;
            $manufacture->zip_code = $request->zip_code;
            $manufacture->manufacture_by = $request->manufacture_by;
            $manufacture->manufacture_date = $request->manufacture_date;
            $manufacture->save();

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
            if($request->color) {
                $color_update = Color::where('color_product_id',$id)->delete();
                // dd($color_update);
                foreach($request->color as $c){
                $color[] = $c;
                $insert_color =  Color::create([
                    'color_cat_id'        => $request->cat_id,
                    'color_subcat_id'     => $request->sub_cat_id,
                    'color_product_id'    => $id,
                    'color'               => $c,
                    ]);
                    // dd($insert_color);
                }
            }
            if($request->size) {
                $size_update = Size::where('size_product_id',$id)->delete();
                // dd($size_update);
                foreach($request->size as $s){
                $size[] = $s;
                $insert_size =  size::create([
                    'size_cat_id'        => $request->cat_id,
                    'size_subcat_id'     => $request->sub_cat_id,
                    'size_product_id'    => $id,
                    'size'               => $s,
                    ]);
                    // dd($insert_size);
                }
            }
            if($request->brand) {
                $brand_update = Brand::where('brand_product_id',$id)->delete();
                // dd($brand_update);
                foreach($request->brand as $b){
                $brand[] = $b;
                $insert_brand =  brand::create([
                    'brand_cat_id'        => $request->cat_id,
                    'brand_subcat_id'     => $request->sub_cat_id,
                    'brand_product_id'    => $id,
                    'brand'               => $b,
                    ]);
                    // dd($insert_brand);
                }
            }
        
        $product->fill($validated);  
        $product->offer = $request->offer;      
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
        $product = Product::find($id);

        $images = DB::table('product_images')
        ->where('product_id', $product->id)
        ->get('images');
        // dd(($images[0]->images));

        foreach ($images as $i) {
            $img = $i->images;
            // dd($i->images);
            // dd(file_exists(public_path('images/product/'.$img)));
            if(file_exists(public_path('images/product/'.$img))){
                unlink(public_path('images/product/'.$img));
            }
        }
        $getrecord = Product::with('images')->find($id);
        $getrecord->delete();
        return redirect('admin/product')->with('error', 'Record deleted Successfully!');
    }

    public function import_excel_list(Request $request){

        $data['meta_title'] = 'Product Excel Import';
        return view('backend.product.excel.import_excel_add', $data);
        
    }

    public function import_store(Request $request){

        // $file  = $request->file('file');
        $file  = $request->file('file')->store('import');
        //dd($file);
        (new ProductsImport)->import($file);
        //Excel::import(new ProductsImport, $file);

        return redirect()->back()->with('success',"Record successfully register.");
    }
   
}
