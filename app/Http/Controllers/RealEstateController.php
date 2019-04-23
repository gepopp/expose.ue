<?php

namespace App\Http\Controllers;

use App\File;
use App\ObjektMeta;
use App\RealEstate;
use App\RealEstateMeta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RealEstateController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $metas = ObjektMeta::all();
        return view('realestate.create')->with('metas', $metas);
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
           'name' => 'required|max:100',
           'description' => 'required',
           'file_id' => 'required|exists:files,id'
        ],[
            'name.required' => 'Bitte geben Sie eine Bezeichnung ein!',
            'description.required' => 'Bitte geben Sie eine Beschreibung ein!',
            'file_id.required' =>  'Bitte laden Sie mind. eine Datei hoch!'
        ]);

        $realEstate = RealEstate::create([
            'name' => $request->name,
            'description' => $request->description
        ]);

        $realEstate->titleimage()->save(File::find($request->file_id));

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
            'name' => 'required|max:100',
            'description' => 'required',
            'file_id' => 'required|exists:files,id'
        ],[
            'name.required' => 'Bitte geben Sie eine Bezeichnung ein!',
            'description.required' => 'Bitte geben Sie eine Beschreibung ein!',
            'file_id.required' =>  'Bitte laden Sie mind. eine Datei hoch!'
        ]);

        $realestate->update([
            'name' => $request->name,
            'description' => $request->description
        ]);
        File::find($request->file_id)->uploadable($realestate);

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
        $realestate->delete();
        return back();
    }
}
