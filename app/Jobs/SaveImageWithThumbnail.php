<?php

namespace App\Jobs;

use App\File;
use App\HasFile;
use http\Env\Request;
use Illuminate\Bus\Queueable;
use Illuminate\Http\File as HFile;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class SaveImageWithThumbnail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    use HasFile;


    protected $folder;
    protected $file_path;
    protected $file_name;
    protected $user_id;
    protected $realtedObject;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($folder, $file_path, $file_name, $realtedObject, $user_id)
    {
        $this->file_path = $file_path;
        $this->file_name = $file_name;
        $this->folder = $folder;
        $this->user_id = $user_id;
        $this->realtedObject = $realtedObject;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $store = Storage::putFile($this->folder, new HFile($this->file_path));
        unlink($this->file_path);

        $file = new File;
        $file->user_id = $this->user_id;
        $file->name = $this->file_name;
        $file->path = $store;
        $file->size = Storage::size($store);
        $file->type = "image/jpg";
        $file->uploadable()->associate( $this->realtedObject );
        $file->save();

    }
}
