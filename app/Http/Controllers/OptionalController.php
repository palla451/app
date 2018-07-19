<?php

namespace App\Http\Controllers;

use App\Optional;
use Illuminate\Http\Request;

class OptionalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('dashboard.optional_booking');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.add_new_optional');
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


    public function show($id)
    {
        $optionals = Optional::all();

         $booking_id =  $id;

        return view('dashboard.optional_booking',compact('optionals','booking_id'));
    }


    public function edit($id)
    {
        $optionals = Optional::findOrFail($id);

     //   return $optionals;
        return view('dashboard.optional_booking', compact('optionals'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Optional  $optional
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Optional $optional)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Optional  $optional
     * @return \Illuminate\Http\Response
     */
    public function destroy(Optional $optional)
    {
        //
    }
}
