<?php

namespace App\Http\Controllers;

use App\File;
use App\RealEstate;
use App\RealEstateAddress;
use Illuminate\Http\Request;

class RealEstateAddressController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(RealEstate $realEstate)
    {
        return view('realestate.address.index')->with('realEstate', $realEstate);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(RealEstate $realEstate)
    {
        return view('realestate.address.create')->with('realEstate', $realEstate);
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
            'name'              => 'required|max:100',
            "address_line_1"    => 'required',
            "zip"               => 'required',
            "city"              => 'required',
        ]);

        $address = RealEstateAddress::create([
            'name' => $request->name,
            'description' => $request->description,
            'real_estate_id' => $realEstate->id,
            "is_public" => $request->is_public ?: 0,
            "address_line_1" => $request->address_line_1,
            "address_line_2" => $request->address_line_2,
            "zip" => $request->zip,
            "city" => $request->city,
            "country" => $request->country,
            "description" => $request->description
        ]);
        $address->image()->save(File::find($request->file_id));

        return redirect(route('realestate.address.index', $realEstate));

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\RealEstateAddress  $realEstateAddress
     * @return \Illuminate\Http\Response
     */
    public function show(RealEstateAddress $realEstateAddress)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\RealEstateAddress  $realEstateAddress
     * @return \Illuminate\Http\Response
     */
    public function edit(RealEstate $realEstate, RealEstateAddress $realEstateAddress)
    {
        return view('realestate.address.edit')->with(['realEstate' => $realEstate, 'realEstateAddress' => $realEstateAddress]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\RealEstateAddress  $realEstateAddress
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, RealEstate $realEstate, RealEstateAddress $realEstateAddress)
    {
        $request->validate([
            'name'              => 'required|max:100',
            "address_line_1"    => 'required',
            "zip"               => 'required',
            "city"              => 'required',
        ]);

        $realEstateAddress->update([
            'name' => $request->name,
            'description' => $request->description,
            'real_estate_id' => $realEstate->id,
            "is_public" => $request->is_public ?: 0,
            "address_line_1" => $request->address_line_1,
            "address_line_2" => $request->address_line_2,
            "zip" => $request->zip,
            "city" => $request->city,
            "country" => $request->country,
            "description" => $request->description
        ]);
        $realEstateAddress->image()->save(File::find($request->file_id));

        return redirect(route('realestate.address.index', $realEstate));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\RealEstateAddress  $realEstateAddress
     * @return \Illuminate\Http\Response
     */
    public function destroy(RealEstate $realEstate, RealEstateAddress $realEstateAddress)
    {
        $realEstateAddress->delete();
        return back();
    }
}
