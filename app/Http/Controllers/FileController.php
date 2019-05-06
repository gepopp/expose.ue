<?php

namespace App\Http\Controllers;

use App\File;
use App\RealEstate;
use Illuminate\Http\File as HFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Image;


class FileController extends Controller
{


    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $folder, $uploadable = null, $uploadableid = null)
    {

        if ($request->file('file')) {
            $file = $request->file('file');
            $mime = $file->getClientMimeType();
            $name = $file->getClientOriginalName();

            $path = $request->file('file')->store($folder);

            $file = new File();

            $file->name = $name;
            $file->path = $path;
            $file->size = Storage::size($path);
            $file->type = $mime;
            $file->user_id = Auth::user()->id;

            if($uploadable){
                $file->uploadable_type = 'App\\' . $uploadable;
                $file->uploadable_id = $uploadableid;
            }

            $file->save();



            return response()->json(['success' => 'Upload erfolgreich', 'id' => $file->id]);
        }
    }

    public function sort(Request $request){
        foreach($request->all() as $key => $file){
            File::find( $file['id'])->update([ 'order' => $key]);
        }
    }

    public function update(Request $request, File $file){
        $file->update($request->all());
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param \App\File $file
     * @return \Illuminate\Http\Response
     */
    public function destroy(File $file)
    {
        $file->delete();
    }
}
