<?php

namespace App\Observers;

use App\File;
use Illuminate\Http\File as HFile;
use Illuminate\Support\Facades\Storage;
use Image;

class FileObserver
{
    /**
     * Handle the file "created" event.
     *
     * @param  \App\File  $file
     * @return void
     */
    public function created(File $file)
    {

       if( !$file->thumb_name && ( $file->type == 'image/jpeg' || $file->type == 'image/jpg' || $file->type == 'image/png' )){

           $image = Storage::get($file->path);

           Image::make($image)->fit(100)->save(public_path( $file->name ));

            $thumb_name =  Storage::putFile('thumbs', new HFile(public_path( $file->name)));

            $file->update(['thumb_name' => $thumb_name]);

            unlink(public_path( $file->name));

       }

    }

    /**
     * Handle the file "updated" event.
     *
     * @param  \App\File  $file
     * @return void
     */
    public function updated(File $file)
    {
        //
    }

    /**
     * Handle the file "deleted" event.
     *
     * @param  \App\File  $file
     * @return void
     */
    public function deleted(File $file)
    {
        Storage::delete($file->path);
        Storage::delete($file->thumb_name);
    }

    /**
     * Handle the file "restored" event.
     *
     * @param  \App\File  $file
     * @return void
     */
    public function restored(File $file)
    {
        //
    }

    /**
     * Handle the file "force deleted" event.
     *
     * @param  \App\File  $file
     * @return void
     */
    public function forceDeleted(File $file)
    {
        //
    }
}
