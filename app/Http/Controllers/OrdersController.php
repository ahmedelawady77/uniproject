<?php

namespace App\Http\Controllers;

use App\Models\orders;
use Illuminate\Http\Request;

class OrdersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orders = orders::all();
        return view('orders.orders',compact('orders'));
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
    public function show(orders $orders)
    {
    $ordersshipped = orders::wherestatus('Deliverd')->get();
    return view('orders.ordershipped',compact('ordersshipped'));
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
    public function destroy(Request $request)
    {
        $id = $request->id;
        $order = orders::where('id', $id)->first();
        $order->delete();
        return redirect()->back();

    }

    public function update_status(Request $request)
    {
        $orders = orders::findOrFail($request->id);
        $orders->update([
            'status' => $request->status,
        ]);
        session()->flash('edit', 'تم تعديل الحاله بنجاح');
        return redirect()->back();
        // dd($request->status);
    }

}
