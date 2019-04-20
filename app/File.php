<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    protected $guarded = [];

    public function gallery(){
        return $this->belongsTo(RealEstateGallery::class );
    }
}
