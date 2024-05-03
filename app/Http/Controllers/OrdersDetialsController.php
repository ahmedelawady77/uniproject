<?php

namespace App\Http\Controllers;

use App\Models\orders;
use Illuminate\Http\Request;
use App\Models\orders_details;

class OrdersDetialsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
    //    $arr = $request->keys() ;
    //     dd( $arr[0] );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // 
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request , $id)
    {
        $orderdetails = orders_details::where('order_id',$id)->get();
        return view('orders.orderdetials',compact('orderdetails'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(orders $orders)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, orders $orders)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(orders $orders)
    {
        //
    }
}
