<?php

namespace App\Http\Controllers;

use App\File;
use App\RealEstate;
use App\RealEstateGallery;
use Illuminate\Http\Request;

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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RealEstate $realEstate, Request $request)
    {

        $gallery = new RealEstateGallery();
        $gallery = $gallery->create([
            'name' => $request->name,
            'description' => $request->description,
            'real_estate_id' => $realEstate->id,
            'is_public' => $request->is_public ?: 0
        ]);

        $files = explode(',', $request->uploaded);

        foreach($files as $file){
            File::where('id', $file)->update(['real_estate_gallery_id' => $gallery->id]);
        }

        $realEstate = RealEstate::find($realEstate->id);
        dd($realEstate);





    }

    /**
     * Display the specified resource.
     *
     * @param  \App\RealEstateGallery  $realEstateGallery
     * @return \Illuminate\Http\Response
     */
    public function show(RealEstateGallery $realEstateGallery)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\RealEstateGallery  $realEstateGallery
     * @return \Illuminate\Http\Response
     */
    public function edit(RealEstateGallery $realEstateGallery)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\RealEstateGallery  $realEstateGallery
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, RealEstateGallery $realEstateGallery)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\RealEstateGallery  $realEstateGallery
     * @return \Illuminate\Http\Response
     */
    public function destroy(RealEstateGallery $realEstateGallery)
    {
        //
    }
}
