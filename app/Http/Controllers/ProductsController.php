<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\products;
use App\Models\categories;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use App\Models\maincategories;
use App\Models\productsimeges;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

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
        $photos = ProductImage::all();
        return view('products.products',compact('products','categories','maincategories','photos')); 
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
        
        // if ($validator->fails()) {
        //     return back()->withErrors($validator)->withInput();
        // }

        Products::create([
            'name' => $request->name,
            'price' => $request->price,
            'category_id' => $request->categories,
            'maincategory_id' =>  $request->maincategories, 
            'description' => $request->description,
            'namebrand' => $nameowner ,
        ]);
    
        $product_id = Products::latest()->first()->id;
        $request->hasFile('pic') && $request->file('pic');
        $image = $request->file('pic');
        $fileName = $request->input('name') . '.' . $image->getClientOriginalExtension();

        Storage::disk('upload_image')->putFileAs('', $image, $fileName);
    
        ProductImage::create([
            'file_name' => $fileName,
            'product_name' => $request->name,
            'created_by' => auth()->user()->name, 
            'product_id' => $product_id,
        ]);      
        
        session()->flash('Add', 'تم اضافة المنتج بنجاح ');
        // // // return view('products.products',compact('products','categories','maincategories')); 
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
    public function edit($id)
    {
        $product = products::findorfail($id);;
        $category = categories::all();
        $maincategory = maincategories::all();
        $photo = ProductImage::all();
        return view('products.edit',compact('product','category','maincategory','photo')); 

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request , $id)
    {
        $products = products::findOrFail($request->id);
        $products->update([
            'name' => $request->name,
            'price' => $request->price,
            'category_id' => $request->category_id,
            'maincategory_id' => $request->maincategory_id,    
            'description' => $request->description,
        ]);
        session()->flash('edit', 'تم تعديل المنتج بنجاح');
        return back();    
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {       
        $id = $request->id;
        $products = products::where('id', $id)->first();
        if($request->page_id==1)
        {
            if ($products->image && Storage::disk('upload_image')->exists($products->image->file_name))
            {
                Storage::disk('upload_image')->delete($products->image->file_name);
            }
            $products->delete();
            //    products::destroy($request->id) on 1&2 lines
            return redirect()->back();
        }         
    }

}
