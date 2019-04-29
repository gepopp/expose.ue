<?php

namespace App\Http\Controllers;

use App\RealEstate;
use App\RealEstateLocation;
use Illuminate\Http\Request;

class RealEstateLocationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(RealEstate $realEstate)
    {
        return view('realestate.location.index')->with('realEstate', $realEstate);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(RealEstate $realEstate)
    {
        return view('realestate.location.create')->with('realEstate', $realEstate);
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
            "name" => "required",
            "description" => "required",
            "zoom" => "required|integer",
            "radius" => "integer",
            "type" => "required",
            "marker" => "required",
            "lat_lng" => "required"
        ]);

        RealEstateLocation::create([
            "real_estate_id" => $realEstate->id,
            "is_public" => $request->is_public ?: 0,
            "name" => $request->name,
            "description" => $request->description,
            "lat_lng" => $request->lat_lng,
            "zoom" => $request->zoom,
            "type" => $request->type,
            "marker" => $request->marker,
            "marker_location" => $request->marker_location,
            "radius" => $request->radius ?: 0,
        ]);

        return redirect(route('realestate.location.index', $realEstate));

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\RealEstateLocation  $realEstateLocation
     * @return \Illuminate\Http\Response
     */
    public function show(RealEstateLocation $realEstateLocation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\RealEstateLocation  $realEstateLocation
     * @return \Illuminate\Http\Response
     */
    public function edit(RealEstate $realEstate, RealEstateLocation $realEstateLocation)
    {
        return view('realestate.location.edit')->with(['realEstate' => $realEstate, 'realEstateLocation' => $realEstateLocation]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\RealEstateLocation  $realEstateLocation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, RealEstate $realEstate, RealEstateLocation $realEstateLocation)
    {

        $request->validate([
            "name" => "required",
            "description" => "required",
            "zoom" => "required|integer",
            "radius" => "integer",
            "type" => "required",
            "marker" => "required",
            "lat_lng" => "required"
        ]);

        $realEstateLocation->update([
            "real_estate_id" => $realEstate->id,
            "is_public" => $request->is_public ?: 0,
            "name" => $request->name,
            "description" => $request->description,
            "lat_lng" => $request->lat_lng,
            "zoom" => $request->zoom,
            "type" => $request->type,
            "marker" => $request->marker,
            "marker_location" => $request->marker_location,
            "radius" => $request->radius ?: 0,
        ]);

        return redirect(route('realestate.location.index', $realEstate));

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\RealEstateLocation  $realEstateLocation
     * @return \Illuminate\Http\Response
     */
    public function destroy(RealEstate $realEstate, RealEstateLocation $realEstateLocation)
    {
        $realEstateLocation->delete();
        return back();
    }
}
