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

            Image::make($file)->fit(100)->save($name);
            $thumb_path = Storage::putFile($folder, new HFile(public_path() . '/' . $name));

            unlink(public_path() . '/' . $name);

            $file = new File();

            $file->name = $name;
            $file->path = $path;
            $file->thumb_name = $thumb_path;
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
