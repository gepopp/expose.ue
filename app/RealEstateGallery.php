<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RealEstateGallery extends Model
{
    protected $guarded = [];

    protected $with = ['images'];

    public function realEstate(){
        return $this->belongsTo(RealEstate::class);
    }

    public function images(){
        return $this->morphMany(File::class, 'uploadable');
    }


}
