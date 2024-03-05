<?php

namespace App\Http\Controllers;

use App\Models\maincategories;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class maincategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $maincategories = maincategories::all();
        return view('categories.maincategories',compact('maincategories')); 
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
            'maincategory' => 'required|unique:maincategories|max:255',
        ], [
            'maincategory.required' => 'يرجي ادخال اسم القسم',
            'maincategory.unique' => 'اسم القسم مسجل مسبقا',
        ]);

        maincategories::create([
            'maincategory' => $request->maincategory,
            'Created_by' => (Auth::user()->name),

        ]);
        session()->flash('Add', 'تم اضافة القسم بنجاح '); 
        return redirect('/maincategories');
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
    //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
    //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $id = $request->id;
        maincategories::find($id)->delete();
        session()->flash('delete','تم حذف القسم بنجاح');
        return redirect('/maincategories');
    }
}
