<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Favourites;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $getrecord = TripModel::orderBy('id', 'desc')->select('trip.*');
        $getrecord = $getrecord->join('users', 'trip.user_id', '=', 'users.id');
        $getrecord = $getrecord->join('cab', 'trip.cab_id', '=', 'cab.id');
        $getrecord = $getrecord->join('location', 'trip.location_id', '=', 'location.id');
        // Search Box Start

        if (!empty($request->idsss)) {
        $getrecord = $getrecord->where('trip.id', '=', $request->idsss);
        }

        if (!empty($request->name)){
        $getrecord = $getrecord->where('users.name', 'like', '%' . $request->name . '%');
        }

        if (!empty($request->registration_no)){
        $getrecord = $getrecord->where('cab.registration_no', 'like', '%' . $request->registration_no . '%');
        }

        if(!empty($request->pick_address)){
        $getrecord = $getrecord->where('location.pick_address', 'like', '%' . $request->pick_address . '%');
        }

        if (!empty($request->phone)){
        $getrecord = $getrecord->where('trip.phone', 'like', '%' . $request->phone . '%');
        }

        // Search Box End
        $getrecord = $getrecord->paginate(40);
        $data['getrecord'] = $getrecord;
        $data['meta_title'] = 'Trip List';
        return view('backend.trip.list', $data);
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
