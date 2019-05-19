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
        $file_name = str_replace(' ', '_', $realatedObject->name) . '-' . time() . '.jpg';
        $file_path = public_path( $file_name );
        $image = Image::make($array[1])->save($file_path);
        $image->destroy();
        SaveImageWithThumbnail::dispatch($folder, $file_path, $file_name, $realatedObject, Auth::user()->id);
    }
}