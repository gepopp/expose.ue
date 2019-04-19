<?php

namespace App\Http\Controllers;

use App\RealEstate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RealEstateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('realestate.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
           'name' => 'required|max:50',
           'description' => 'required',
           'titleimage_id' => 'required|exists:files,id'
        ]);

        RealEstate::create($request->all());

        return redirect(route('home'));

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\RealEstate  $realEstate
     * @return \Illuminate\Http\Response
     */
    public function show(RealEstate $realEstate)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\RealEstate  $realEstate
     * @return \Illuminate\Http\Response
     */
    public function edit(RealEstate $realestate)
    {
        return view('realestate.edit')->with( ['realEstate' => $realestate ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\RealEstate  $realEstate
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, RealEstate $realestate)
    {
        $request->validate([
            'name' => 'required|max:50',
            'description' => 'required',
            'titleimage_id' => 'required|exists:files,id'
        ]);

        $realestate->update($request->all());
        return redirect(route('home'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\RealEstate  $realEstate
     * @return \Illuminate\Http\Response
     */
    public function destroy(RealEstate $realestate)
    {

        Storage::delete($realestate->titleimage->path);
        Storage::delete($realestate->titleimage->thumb_name);
        $realestate->titleimage->delete();
        $realestate->delete();
        return back();
    }
}
