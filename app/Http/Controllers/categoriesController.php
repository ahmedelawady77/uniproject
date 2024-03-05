<?php

namespace App\Http\Controllers;

use App\Models\categories;
use Illuminate\Http\Request;
use App\Models\maincategories;
use Illuminate\Support\Facades\Auth;

class categoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = categories::all();
        $maincategories = maincategories::all();
        return view('categories.categories',compact('categories','maincategories')); 
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
        $request->validate([
            'categoryname' => 'required|unique:categories|max:255',
        ], [

            'categoryname.required' => 'يرجي ادخال اسم القسم',
            'categoryname.unique' => 'اسم القسم مسجل مسبقا',
        ]);
        categories::create([
            'categoryname' => $request->categoryname,
            'Created_by' => (Auth::user()->name),

        ]);
        session()->flash('Add', 'تم اضافة القسم بنجاح '); 
        return redirect('/categories');
    }

    /**
     * Display the specified resource.
     */
    // public function show(sections $sections)
    // {
    //     //
    // }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request)
    {
        $categories = categories::all();
        return view('categories.categories',compact('categories')); 
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $id = $request->id;

        // $this->validate($request, [
        //     'categoryname' => 'required|max:255|unique:categories,categoryname,'.$id,
        // ],[
        //     'categoryname.required' =>'يرجي ادخال اسم القسم',
        //     'categoryname.unique' =>'اسم القسم مسجل مسبقا',
        // ]);
        
        $id = categories::find($id);
        $id->update([
            'categoryname' => $request->categories,
        ]);

        session()->flash('edit','تم تعديل القسم بنجاج');
        return redirect('/categories');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $id = $request->id;
        categories::find($id)->delete();
        session()->flash('delete','تم حذف القسم بنجاح');
        return redirect('/categories');
    }
}
