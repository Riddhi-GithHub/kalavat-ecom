<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Order;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $getrecord = Order::orderBy('order_id', 'desc')->select('orders.*');
        $getrecord = $getrecord->join('products', 'orders.product_id', '=', 'products.id');
        // $getrecord = $getrecord->join('users', 'orders.user_id', '=', 'users.id');

    	if (!empty($request->order_id)) {
			$getrecord = $getrecord->where('order_id', '=', $request->order_id);
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
    	$data['meta_title'] = 'Order List';
    	return view('backend.order.list', $data);  
    }

    public function OderschangeStatus(Request $request)
    {
        // echo "string";
        // die();
        $changeStatus = Order::find($request->status_change_id);

        $changeStatus->status = $request->status_id;
         //dd($changeStatus->status);
        $changeStatus->save();
        
        $json['success'] = true;
        echo json_encode($json);
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
}
