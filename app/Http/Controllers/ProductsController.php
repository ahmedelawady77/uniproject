<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\products;
use App\Models\categories;
use Illuminate\Http\Request;
use App\Models\maincategories;
use Illuminate\Support\Facades\Auth;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() 
    {
        $products = products::all();
        $categories = categories::all();
        $maincategories = maincategories::all();
        return view('products.products',compact('products','categories','maincategories')); 
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
        $nameowner =Auth::user()->id ;

        $request->validate([
            'name' => 'required|max:255',
            'price' => 'required',
            'maincategories' => 'required|integer',
            'categories' => 'required',
        ], [
            'Product_name.required' => 'يرجي ادخال اسم المنتج',
        ]);

        Products::create([
            'name' => $request->name,
            'price' => $request->price,
            'category_id' => $request->categories,
            'maincategory_id' =>  $request->maincategories, 
            'description' => $request->description,
            'namebrand' => $nameowner ,
        ]);
        session()->flash('Add', 'تم اضافة المنتج بنجاح ');
        // return view('products.products',compact('products','categories','maincategories')); 
           return redirect()->back();

    }

    /**
     * Display the specified resource.
     */
    public function show(products $products)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(products $products)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, products $products)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(products $products)
    {
        //
    }
}
