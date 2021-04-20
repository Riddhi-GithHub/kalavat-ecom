<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Catalog;
use App\Models\Product;
use App\Models\Category;
use App\Models\Sub_Category;

class CatalogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $getrecord = Catalog::orderBy('id', 'desc');
    	// Search Box Start
    	
    	if (!empty($request->id)) {
			$getrecord = $getrecord->where('id', '=', $request->id);
		}
		if (!empty($request->catalog_title)) {
			$getrecord = $getrecord->where('catalog_title', 'like', '%' . $request->catalog_title . '%');
		}
    	// Search Box End
    	$getrecord = $getrecord->paginate(40);
    	$data['getrecord'] = $getrecord;
    	$data['meta_title'] = 'Catalog List';
    	return view('backend.catalog.list', $data);
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
        $data['subcategory'] = Sub_Category::get();
        $product = Product::get();
        $data['getproduct'] = $product;
        $data['meta_title'] = "Add Catalog";
    	return view('backend.catalog.add', $data);
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
            'sub_category_id'         => 'required',
            'catalog_title'         => 'required',
            'catalog_description'         => 'required',
            'catalog_amount'         => 'required',
            'catalog_size'         => 'required',
            'catalog_brand'         => 'required',
            'product_id'         => 'required',
            'catalog_image' => 'required|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // dd($input);
        $p_id = implode(',', $request->product_id); 
        $model_num = rand(1111111111,9999999999);
        $num = 'CL'.$model_num;
        // dd($p_id);
        
        // $catalog_add = Catalog::create($input);
        // $catalog_add->catalog_unique_id = $num;
        
        if ($request->hasFile('catalog_image')) {
            $image = $request->file('catalog_image');
            $no = rand(1111,9999);
            $image_name = time().$no.'.jpg';
            $i = $image->move(public_path('images/catalog'), $image_name);
    
            // $catalog_add->catalog_image = $image_name;

            $catalog = new Catalog([
                        'sub_category_id'      =>  $request->get('sub_category_id'),
                        'catalog_title'      =>  $request->get('catalog_title'),
                        'catalog_description'      =>  $request->get('catalog_description'),
                        'catalog_amount'      =>  $request->get('catalog_amount'),
                        'catalog_size'      =>  $request->get('catalog_size'),
                        'catalog_brand'      =>  $request->get('catalog_brand'),
                        'catalog_unique_id'            =>  $num,
                        'catalog_image'            =>  $image_name,
                        'product_id'               =>  $p_id,
                    ]);
                    $catalog->save();
            } 
        // if($request->product_id)
        // {
        //     $p_id = implode(',', $request->product_id); 
        //     $catalog_add->product_id = $p_id;
        // }
        // $catalog_add->save();

        return redirect('admin/catalog')->with('success', 'catalog added Successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data['getcatalog'] = Catalog::find($id);
        $data['meta_title'] = "view Catalog";
        return view('backend.catalog.view', $data);
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

        $cat = Catalog::find($id);
        $product_id = $cat->product_id;
        $array_product_id = explode(',', $product_id);
        $data['productdata'] = Product::whereIn('id',$array_product_id)->get();
        $data['getproduct'] = Product::get();

        $data['getcatalog'] = Catalog::find($id);
        $data['meta_title'] = "Edit Catalog";
        return view('backend.catalog.edit', $data);
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
            'sub_category_id'         => 'required',
            'catalog_title'         => 'required',
            'catalog_description'         => 'required',
            'catalog_amount'         => 'required',
            'catalog_size'         => 'required',
            'catalog_brand'         => 'required',
            'product_id'         => 'required',
        ]);

        $p_id = implode(',', $request->product_id); 

            $catalog_update = Catalog::find($id);
            $catalog_update->fill($validated);  
            $catalog_update->product_id = $p_id;

            if (!empty($request->file('catalog_image')))
            {
                // dd(file_exists(public_path('images/catalog/'.$catalog_update->image)));
                if (!empty($catalog_update->catalog_image) && file_exists(public_path('images/catalog/'.$catalog_update->catalog_image)))
                {
                    unlink(public_path('images/catalog/'.$catalog_update->catalog_image));
                }
                $image = $request->file('catalog_image');
                    $no = rand(1111,9999);
                    $image_name = time().$no.'.jpg';
                    $i = $image->move(public_path('images/catalog'), $image_name);
                    $catalog_update->catalog_image = $image_name;
            }

        $catalog_update->save();
      
        return redirect('admin/catalog')->with('warning', 'Record updated Successfully!');
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

    public function catalog_delete($id)
    {
        $getrecord = Catalog::find($id);
        // dd(file_exists(public_path('images/catalog/'.$getrecord->catalog_image)));
        if(file_exists(public_path('images/catalog/'.$getrecord->catalog_image))){
            unlink(public_path('images/catalog/'.$getrecord->catalog_image));
        }
        $getrecord->delete();
        return redirect('admin/catalog')->with('error', 'Record successfully deleted!');
    }
}
