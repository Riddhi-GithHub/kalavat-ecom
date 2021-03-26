<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Sale;

class SaleController extends Controller
{
    public function index(Request $request)
    {
        $getrecord = Sale::orderBy('id', 'desc');
    	
    	if (!empty($request->id)) {
			$getrecord = $getrecord->where('id', '=', $request->id);
		}

		if (!empty($request->sale_title)) {
			$getrecord = $getrecord->where('sale_title', 'like', '%' . $request->sale_title . '%');
		}

    	// Search Box End
    	$getrecord = $getrecord->paginate(40);
    	$data['getrecord'] = $getrecord;
    	$data['meta_title'] = 'Sale List';
    	return view('backend.sale.list', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['meta_title'] = "Add Sale";
    	return view('backend.sale.add', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $sale = request()->validate([
            'sale_title'         => 'required',
            'sale_description'         => 'required',
            'sale_end_date'         => 'required|date_format:"Y-m-d"',
        ]);
        $sale = new Sale([
                    'sale_title'        =>  $request->get('sale_title'),
                    'sale_description'   =>  $request->get('sale_description'),
                    'sale_end_date'       =>  $request->get('sale_end_date'),
                ]);
                // dd($sale);
        $sale->save();
     
        return redirect('admin/sale')->with('success', 'Sale added Successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data['getsale'] = Sale::find($id);
        $data['meta_title'] = "View Sale";
        return view('backend.sale.view', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['getsale'] = Sale::find($id);
        $data['meta_title'] = "Edit Sale";
        return view('backend.sale.edit', $data);
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
            'sale_title'         => 'required',
            'sale_description'         => 'required',
            'sale_end_date'         => 'required|date_format:"Y-m-d"',
        ]);
            $sale_update = Sale::find($id);
            $sale_update->fill($validated);  
            $sale_update->save();
      
        return redirect('admin/sale')->with('warning', 'Record updated Successfully!');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function destroy($id)
    // {
    //     $getrecord = Sale::find($id);
    //     $getrecord->delete();
    //     return redirect('admin/Sale')->with('error', 'Record successfully deleted!');
    // }

    public function Sale_delete($id)
    {
        $getrecord = Sale::find($id);
    //    dd($getrecord);
        $getrecord->delete();
        return redirect('admin/sale')->with('error', 'Record successfully deleted!');
    }
}
