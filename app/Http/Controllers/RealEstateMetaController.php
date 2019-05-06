<?php

namespace App\Http\Controllers;

use App\HasFile;
use App\ObjektMeta;
use App\RealEstate;
use App\RealEstateMeta;
use Illuminate\Http\Request;
use App\File;
use Illuminate\Http\File as HFile;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Image;

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

        $this->FileSaveTo($request, $objektMeta);

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

        $img = Storage::get($realEstateMeta->image->path);
        $base64 = Image::make($img)->encode('data-url');


        return view('realestate.meta.edit')->with(['realEstate' => $realEstate, 'realEstateMeta' => $realEstateMeta, 'img' => $base64->encoded]);
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


        if($request->file_changed){

        }


         $realEstateMeta->update([
            'real_estate_id' => $realEstate->id,
            'name' => $request->name,
            'is_public' => $request->is_public ?: 0,
            'metadata' =>  $this->buildMetaJson($request->meta)
        ]);
        $realEstateMeta->image()->save(File::find($request->file_id));

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
            if($meta[0]){
                $metadata = ObjektMeta::find($key);
                $metadata->value = $meta[0];
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
