<?php

namespace App\Http\Controllers;

use App\HasFile;
use App\RealEstate;
use App\RealEstateText;
use Illuminate\Http\Request;
use App\File;

class RealEstateTextController extends Controller
{
    use HasFile;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(RealEstate $realEstate)
    {
        return view('realestate.text.index')->with('realEstate', $realEstate);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(RealEstate $realEstate)
    {
        return view('realestate.text.create')->with('realEstate', $realEstate);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, RealEstate $realEstate)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'file_data' => 'required'
        ],[
                'name.required' => 'Bitte geben Sie eine Bezeichnung ein!',
                'description.required' => 'Bitte geben Sie eine Beschreibung ein!',
            ]);

        $text = RealEstateText::create(array_merge([
            'real_estate_id'=>$realEstate->id,
            'name' => $request->name,
            'description' => $request->description,
            'is_public' => $request->is_public ?: 0
            ]));

        $this->FileSaveTo($request, $text, 'textimage');
        return redirect(route('realestate.text.index', $realEstate));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\RealEstateText  $realEstateText
     * @return \Illuminate\Http\Response
     */
    public function show(RealEstateText $realEstateText)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\RealEstateText  $realEstateText
     * @return \Illuminate\Http\Response
     */
    public function edit(RealEstate $realEstate, RealEstateText $realEstateText)
    {
        return view('realestate.text.edit')->with(['realEstate' => $realEstate, 'realEstateText' => $realEstateText]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\RealEstateText  $realEstateText
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, RealEstate $realEstate, RealEstateText $realEstateText)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'file_data' => 'required'
        ],[
            'name.required' => 'Bitte geben Sie eine Bezeichnung ein!',
            'description.required' => 'Bitte geben Sie eine Beschreibung ein!',
            'file_data.required' =>  'Bitte laden Sie mind. eine Datei hoch!'
        ]);

       $realEstateText->update([
            'real_estate_id'=>$realEstate->id,
            'name' => $request->name,
            'description' => $request->description,
            'is_public' => $request->is_public ?: 0
        ]);
        if( $request->file_changed == "true"){
            $realEstateText->image->delete();
            $this->FileSaveTo($request, $realEstateText, 'textimages');
        }
        return redirect(route('realestate.text.index', $realEstate));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\RealEstateText  $realEstateText
     * @return \Illuminate\Http\Response
     */
    public function destroy(RealEstate $realEstate, RealEstateText $realEstateText)
    {
        $realEstateText->delete();
        return back();
    }
}
