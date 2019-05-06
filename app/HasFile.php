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

        $image_str = $request->file_data;
        $array = explode(',', $image_str);
        $file_name = str_replace(' ', '_', $realatedObject->name) . '-' . time() . '.jpg';
        $file_path = public_path('tmp/' . $file_name);
        Image::make($array[1])->save($file_path, 75);
        SaveImageWithThumbnail::dispatch($folder, $file_path, $file_name, $realatedObject, Auth::user()->id);
    }
}