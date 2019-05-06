<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Image;

class File extends Model
{
    protected $guarded = [];
    protected $url;
    protected $blob;

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('order', function (Builder $builder) {
            $builder->orderBy('order');
        });
    }


    function uploadable(){
        return $this->morphTo();
    }

    public function blob(){
        return Image::make( Storage::get($this->path))->encode('data-url');
    }
    public function url(){
        return Storage::get($this->path);
    }

}
