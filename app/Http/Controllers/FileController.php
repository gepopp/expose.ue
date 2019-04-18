<?php

namespace App\Http\Controllers;

use App\File;
use Illuminate\Http\File as HFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Image;



class FileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {




    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if($request->file('file')){
            $image = $request->file('file');
            $name = $image->getClientOriginalName();
            $path = $request->file('file')->store('public/titleimages'  );

            $img = Image::make($image);
            $img->fit(100);
            $img->save( $name );
            $thumb_path = Storage::putFile('public/titleimages', new HFile(public_path() . '/' . $name ));
            unlink(public_path() . '/' . $name );

        }

        $image = new File();
        $image->name = $name;
        $image->path = $path;
        $image->thumb_name = $thumb_path;
        $image->save();
        return response()->json([
            'success' => 'Upload erfolgreich',
            'id' => $image->id
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\File  $file
     * @return \Illuminate\Http\Response
     */
    public function show(File $file)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\File  $file
     * @return \Illuminate\Http\Response
     */
    public function edit(File $file)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\File  $file
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, File $file)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\File  $file
     * @return \Illuminate\Http\Response
     */
    public function destroy(File $file)
    {
        Storage::delete($file->path);
        $file->delete();
    }
}
