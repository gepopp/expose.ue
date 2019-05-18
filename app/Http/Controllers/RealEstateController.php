<?php

namespace App\Http\Controllers;

use App\File;
use App\HasFile;
use App\ObjektMeta;
use App\RealEstate;
use App\RealEstateMeta;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Jobs\SaveImageWithThumbnail;

class RealEstateController extends Controller
{

    use HasFile;

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
           'name' => 'required|max:100',
           'file_data' => 'required'
        ],[
            'name.required' => 'Bitte geben Sie eine Bezeichnung ein!',
            'file_data.required' =>  'Bitte laden Sie mind. eine Datei hoch!'
        ]);

        $realEstate = RealEstate::create([
            'name' => $request->name,
            'description' => $request->description,
            'street' => $request->street,
            'number' => $request->number,
            'zip' => $request->zip,
            'city' => $request->city,
            'country' => $request->country,
            'show' => $request->show_address
        ]);

        $this->FileSaveTo($request, $realEstate, 'titleimages');
        return redirect(route('home'));
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
            'file_data' => 'required'
        ],[
            'name.required' => 'Bitte geben Sie eine Bezeichnung ein!',
            'file_data.required' =>  'Bitte laden Sie mind. eine Datei hoch!'
        ]);

        $realestate->update([
            'name' => $request->name,
            'description' => $request->description,
            'street' => $request->street,
            'number' => $request->number,
            'zip' => $request->zip,
            'city' => $request->city,
            'country' => $request->country,
            'show' => $request->show_address
        ]);

        if( $request->file_changed == "true"){

            if($realestate->titleimage)
            $realestate->titleimage->delete();

            $this->FileSaveTo($request, $realestate, 'titleimages');
        }

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
        if($realestate->titleimage) $realestate->titleimage->delete();
        $realestate->delete();
        return back();
    }
}
