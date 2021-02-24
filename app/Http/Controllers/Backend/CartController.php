<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Cart;


class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $getrecord = Cart::orderBy('cart_id', 'desc')->select('carts.*')->where('status', '=', 1);
        $getrecord = $getrecord->join('products', 'carts.product_id', '=', 'products.id');
        // $getrecord = $getrecord->join('users', 'carts.user_id', '=', 'users.id');

    	if (!empty($request->cart_id)) {
			$getrecord = $getrecord->where('cart_id', '=', $request->cart_id);
		}

        if (!empty($request->username)) {
			$getrecord = $getrecord->where('username', 'like', '%' . $request->username . '%');
		}

		if (!empty($request->product_name)) {
			$getrecord = $getrecord->where('product_name', 'like', '%' . $request->product_name . '%');
		}
    	// Search Box End
    	$getrecord = $getrecord->paginate(40);
    	$data['getrecord'] = $getrecord;
    	$data['meta_title'] = 'Cart List';
    	return view('backend.cart.list', $data);  
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
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

    public function cartitem_delete($id)
    {
        $data['getcart'] = Favourites::find($id);
        $data['meta_title'] = "Delete Cart Product";
        // dd($data['getfavouriteproduct']);
        if(!($data['getcart']->status == '0'))
        {
            $favDelete = $data['getcart']->update(['status'=>0]);
        }
        return redirect('admin/favouriteitem')->with('error', 'Record deleted Successfully!');
    }
}
