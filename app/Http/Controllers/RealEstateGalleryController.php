<?php

namespace App\Http\Controllers;

use App\File;
use App\RealEstate;
use App\RealEstateGallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RealEstateGalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(RealEstate $realEstate)
    {
        $galleries = $realEstate->gallery;
        return view('gallery.index')->with(['galleries' => $galleries, 'realEstate' => $realEstate]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(RealEstate $realEstate)
    {
        return view('gallery.create')->with('realEstate', $realEstate);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(RealEstate $realEstate, Request $request)
    {

        $request->validate(['name' => 'required', 'description' => 'required', 'file_id' => 'required'], ['name.required' => 'Bitte geben Sie eine Bezeichnung ein!', 'description.required' => 'Bitte geben Sie eine Beschreibung ein!', 'file_id.required' => 'Bitte laden Sie mind. eine Datei hoch!']);

        $gallery = new RealEstateGallery();
        $gallery = $gallery->create(['name' => $request->name, 'description' => $request->description, 'real_estate_id' => $realEstate->id, 'is_public' => $request->is_public ?: 0,]);

        $files = explode(',', $request->file_id);
        foreach ($files as $file) {
            $gallery->images()->save(File::find($file));
        }
        return redirect(route('gallery.sort', [$realEstate, $gallery]));

    }

    /**
     * Display the specified resource.
     *
     * @param \App\RealEstateGallery $realEstateGallery
     * @return \Illuminate\Http\Response
     */
    public function show(RealEstateGallery $realEstateGallery)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\RealEstateGallery $realEstateGallery
     * @return \Illuminate\Http\Response
     */
    public function edit(RealEstate $realEstate, RealEstateGallery $realEstateGallery)
    {
        return view('gallery.edit')->with(['realEstate' => $realEstate, 'realEstateGallery' => $realEstateGallery]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\RealEstateGallery $realEstateGallery
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, RealEstate $realEstate, RealEstateGallery $realEstateGallery)
    {
        $request->validate(['name' => 'required', 'description' => 'required', 'file_id' => 'required'], ['name.required' => 'Bitte geben Sie eine Bezeichnung ein!', 'description.required' => 'Bitte geben Sie eine Beschreibung ein!', 'file_id.required' => 'Bitte laden Sie mind. eine Datei hoch!']);

        $realEstateGallery->update(['name' => $request->name, 'description' => $request->description, 'is_public' => $request->is_public ?: 0,]);

        $files = explode(',', $request->file_id);
        foreach ($files as $file) {
            $realEstateGallery->images()->save(File::find($file));
        }
        return redirect(route('gallery.sort', [$realEstate, $realEstateGallery]));
    }

    public function SortAndLabel(RealEstate $realEstate, RealEstateGallery $realEstateGallery)
    {

        return view('gallery.sort')->with(["realEstateGallery" => $realEstateGallery, 'realEstate' => $realEstate]);

    }


    /**
     * Remove the specified resource from storage.
     *
     * @param \App\RealEstateGallery $realEstateGallery
     * @return \Illuminate\Http\Response
     */
    public function destroy(RealEstate $realEstate, RealEstateGallery $realEstateGallery)
    {
        $realEstateGallery->delete();
        return back();
    }
}
