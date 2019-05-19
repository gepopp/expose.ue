<?php


namespace App;


use App\Jobs\SaveImageWithThumbnail;
use Illuminate\Http\Request;
use Illuminate\Http\File as HFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Image;

trait HasFile
{
    public function FileSaveTo(Request $request, $realatedObject, $folder = 'images'){

        $array = explode(',', $request->file_data);
        $request->file_data = null;

        $clean = preg_replace('/[^A-Za-z0-9]/', '_', $realatedObject->name);


        $file_name =  $clean .  '-' . time() . '.jpg';
        $file_path = public_path( $file_name );
        $image = Image::make($array[1])->save($file_path);
        $image->destroy();
        SaveImageWithThumbnail::dispatch($folder, $file_path, $file_name, $realatedObject, Auth::user()->id);
    }
}