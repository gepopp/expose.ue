<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RealEstate extends Model
{
    protected $guarded = [];

    protected $with = ['titleimage', 'gallery'];

    public function gallery(){
        return $this->hasMany(RealEstateGallery::class, 'real_estate_id');
    }

    public function titleimage(){
        return $this->morphOne(File::class, 'uploadable');
    }
}
