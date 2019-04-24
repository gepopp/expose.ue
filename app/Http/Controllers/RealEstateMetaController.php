<?php

namespace App\Http\Controllers;

use App\ObjektMeta;
use App\RealEstate;
use App\RealEstateMeta;
use Illuminate\Http\Request;

class RealEstateMetaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(RealEstate $realEstate)
    {
        return view('realestate.meta.index')->with(['realEstate' => $realEstate]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(RealEstate $realEstate)
    {
        $metas = ObjektMeta::all();
        return view('realestate.meta.create')->with(['realEstate' => $realEstate, 'metas' => $metas]);
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
     * @param  \App\RealEstateMeta  $realEstateMeta
     * @return \Illuminate\Http\Response
     */
    public function show(RealEstateMeta $realEstateMeta)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\RealEstateMeta  $realEstateMeta
     * @return \Illuminate\Http\Response
     */
    public function edit(RealEstateMeta $realEstateMeta)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\RealEstateMeta  $realEstateMeta
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, RealEstateMeta $realEstateMeta)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\RealEstateMeta  $realEstateMeta
     * @return \Illuminate\Http\Response
     */
    public function destroy(RealEstateMeta $realEstateMeta)
    {
        //
    }
}
