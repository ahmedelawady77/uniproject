<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\regsterUser;
use Illuminate\Http\Request;

class RegsterUserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view ('auth.fakeregster');
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
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'namebrand' => 'nullable|string|max:255',
            'phone' => 'required|string|min:10|max:255',
        ]);
        
        $user = regsterUser::create([
            'name' => $request->name,
            'email' => $request->email,
            'namebrand' => $request->namebrand,
            'phone' => $request->phone,
        ]);
        
        return view ('auth.waitregister');
       

    }

    /**
     * Display the specified resource.
     */
    public function show(regsterUser $regsterUser)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(regsterUser $regsterUser)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, regsterUser $regsterUser)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(regsterUser $regsterUser)
    {
        //
    }
}
