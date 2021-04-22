<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Favourites;

class FavouriteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // $getrecord = Favourites::get();
        // $getrecord = Favourites::orderBy('fav_id', 'desc');
    	// $getrecord = Favourites::orderBy('fav_id', 'desc')->where('status', '=', 1);
       
        // $getrecord = Favourites::orderBy('fav_id', 'desc')->select('favourites.*')->where('status', '=', 1);
        // $getrecord = $getrecord->join('products', 'favourites.product_id', '=', 'products.id');

        $getrecord = Favourites::orderBy('fav_id', 'desc')->select('favourites.*');
        $getrecord = $getrecord->join('users', 'favourites.user_id', '=', 'users.id');
        $getrecord = $getrecord->join('catalogs', 'favourites.catalog_id', '=', 'catalogs.id');
        // $getrecord = $getrecord->join('products', 'favourites.product_id', '=', 'products.id');

        // $getrecord = Product::orderBy('id', 'desc')->select('products.*');
        // $getrecord = $getrecord->join('categories', 'products.cat_id', '=', 'categories.id');
        
    	if (!empty($request->fav_id)) {
			$getrecord = $getrecord->where('fav_id', '=', $request->fav_id);
		}

        if (!empty($request->fullname)) {
			$getrecord = $getrecord->where('fullname', 'like', '%' . $request->fullname . '%');
		}

		if (!empty($request->product_name)) {
			$getrecord = $getrecord->where('product_name', 'like', '%' . $request->product_name . '%');
		}
	
        if (!empty($request->catalog_title)) {
			$getrecord = $getrecord->where('catalog_title', 'like', '%' . $request->catalog_title . '%');
		}

    	// Search Box End
    	$getrecord = $getrecord->paginate(40);
    	$data['getrecord'] = $getrecord;
    	$data['meta_title'] = 'Favourite Product List';
    	return view('backend.favourite.list', $data);  
    }

    public function favouriteitem_delete($id)
    {
        $data['getfavouriteproduct'] = Favourites::find($id);
        $data['meta_title'] = "Delete Favourite Product";
        // dd($data['getfavouriteproduct']);
        if(!($data['getfavouriteproduct']->status == '0'))
        {
            $favDelete = $data['getfavouriteproduct']->update(['status'=>0]);
        }
        return redirect('admin/favouriteitem')->with('error', 'Record deleted Successfully!');
    }
}

