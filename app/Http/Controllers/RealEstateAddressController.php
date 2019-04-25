<?php

namespace App\Http\Controllers;

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
    public function store(Request $request)
    {
        //
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
    public function edit(RealEstateAddress $realEstateAddress)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\RealEstateAddress  $realEstateAddress
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, RealEstateAddress $realEstateAddress)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\RealEstateAddress  $realEstateAddress
     * @return \Illuminate\Http\Response
     */
    public function destroy(RealEstateAddress $realEstateAddress)
    {
        //
    }
}
