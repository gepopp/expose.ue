<?php

namespace App\Http\Controllers;

use App\ObjektMeta;
use Illuminate\Http\Request;

class ObjektMetaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $metas = ObjektMeta::get();
        return view('meta.index')->with(['metas' => $metas]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('meta.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate(['name' => 'required', 'postfix' => 'required']);

        $data = ['name' => $request->name, 'slug' => $this->slugify($request->name), 'postfix' => $request->postfix];
        ObjektMeta::create($data);

        $metas = ObjektMeta::all();

        return redirect(route('meta.index'))->with(['tooltip' => true]);

    }

    /**
     * Display the specified resource.
     *
     * @param \App\ObjektMeta $objektMeta
     * @return \Illuminate\Http\Response
     */
    public function show(ObjektMeta $objektMeta)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\ObjektMeta $objektMeta
     * @return \Illuminate\Http\Response
     */
    public function edit(ObjektMeta $metum)

    {
        return view('meta.edit')->with( [ 'meta' => $metum ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\ObjektMeta $objektMeta
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ObjektMeta $metum)
    {
        $request->validate(['name' => 'required', 'postfix' => 'required']);

        $data = ['name' => $request->name, 'slug' => $this->slugify($request->name), 'postfix' => $request->postfix];

        $metum->update($data);
        return redirect(route('meta.index'))->with(['tooltip' => true]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\ObjektMeta $objektMeta
     * @return \Illuminate\Http\Response
     */
    public function destroy(ObjektMeta $metum)
    {
        $metum->delete();
        return redirect(route('meta.index'))->with(['tooltip' => true]);
    }


    public static function slugify($text)
    {
        // replace non letter or digits by -
        $text = preg_replace('~[^\pL\d]+~u', '-', $text);

        // transliterate
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

        // remove unwanted characters
        $text = preg_replace('~[^-\w]+~', '', $text);

        // trim
        $text = trim($text, '-');

        // remove duplicate -
        $text = preg_replace('~-+~', '-', $text);

        // lowercase
        $text = strtolower($text);

        if (empty($text)) {
            return 'n-a';
        }

        return $text;
    }

    public function sort(){
        $metas = ObjektMeta::get();
        return view('meta.sort')->with(['metas' => $metas]);
    }

    public function resort(Request $request){
        foreach($request->all() as $key => $meta){
            ObjektMeta::find( $meta['id'])->update([ 'order' => $key]);
        }
    }


}
