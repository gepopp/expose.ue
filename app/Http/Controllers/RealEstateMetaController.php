<?php

namespace App\Http\Controllers;

use Image;
use App\File;
use App\HasFile;
use App\ObjektMeta;
use App\RealEstate;
use App\RealEstateMeta;
use Illuminate\Http\Request;
use Illuminate\Http\File as HFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class RealEstateMetaController extends Controller
{

    use HasFile;
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
    public function store(Request $request, RealEstate $realEstate)
    {

        $request->validate([
            'name' => 'required',
            'file_data' => 'required'
        ],[
            'name.required' => 'Bitte geben Sie einen Titel ein!',
            'file_id.required' => "Bitte laden Sie ein Bild hoch!",
        ]);

        $objektMeta = RealEstateMeta::create([
           'real_estate_id' => $realEstate->id,
           'name' => $request->name,
           'is_public' => $request->is_public ?: 0,
           'metadata' =>  $this->buildMetaJson($request->meta)
        ]);

        $this->FileSaveTo($request, $objektMeta, 'metaimages');

        return redirect(route('realestate.meta.index', $realEstate));
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
    public function edit(RealEstate $realEstate, RealEstateMeta $realEstateMeta)
    {
        $metas = ObjektMeta::all();
        $exists = json_decode($realEstateMeta->metadata);

        foreach($metas as $meta){
            foreach($exists as $exist){
                if($meta->id == $exist->id){
                    $meta->value = $exist->value;
                    $meta->column = $exist->column ?: 'left';
                }
            }
        }
        $ordered = [];
        $metaArr = $metas->toArray();
        foreach($exists as $exist){
            for( $i = 0; $i < count($metaArr); $i++){
                if($metas[$i]->id == $exist->id){
                    $ordered[] = $metas[$i];
                    unset($metaArr[$i]);
                }
            }
        }
        $metas = array_merge($ordered, $metaArr);
        $realEstateMeta->metadata = collect($metas);

        return view('realestate.meta.edit')->with(['realEstate' => $realEstate, 'realEstateMeta' => $realEstateMeta]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\RealEstateMeta  $realEstateMeta
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, RealEstate $realEstate, RealEstateMeta $realEstateMeta)
    {

        $request->validate([
            'name' => 'required',
            'file_data' => 'required'
        ],[
            'name.required' => 'Bitte geben Sie einen Titel ein!',
            'file_id.required' => "Bitte laden Sie ein Bild hoch!"
        ]);


       $realEstateMeta->update([
            'real_estate_id' => $realEstate->id,
            'name' => $request->name,
            'is_public' => $request->is_public ?: 0,
            'metadata' =>  $this->buildMetaJson($request->meta)
        ]);
        if( $request->file_changed == "true"){
            if($realEstateMeta->image){
                $realEstateMeta->image->delete();
            }
            $this->FileSaveTo($request, $realEstateMeta, 'titleimages');
        }

        return redirect(route('realestate.meta.index', $realEstate));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\RealEstateMeta  $realEstateMeta
     * @return \Illuminate\Http\Response
     */
    public function destroy(RealEstate $realEstate, RealEstateMeta $realEstateMeta)
    {
        $realEstateMeta->delete();
        return back();
    }

    public function buildMetaJson($metas){

        $to_json = [];
        foreach ($metas as $key => $meta){
            if($meta['value']){
                $metadata = ObjektMeta::find($key);
                $metadata->value = $meta['value'];
                $metadata->column = !empty($meta['column']) ? $meta['column'] : 'left';
                $to_json[] = $metadata;
            }
        }
        return json_encode( $to_json );
    }

    public function sort(Request $request, RealEstate $realEstate, RealEstateMeta $realEstateMeta){

        $realEstateMeta->update([
            'metadata' => json_encode($request->all())
        ]);


    }

}
