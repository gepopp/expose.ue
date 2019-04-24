<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RealEstate extends Model
{
    protected $guarded = [];

    protected $with = ['titleimage', 'gallery', 'meta', 'text'];

    public function gallery(){
        return $this->hasMany(RealEstateGallery::class, 'real_estate_id');
    }
    public function meta(){
        return $this->hasMany(RealEstateMeta::class, 'real_estate_id');
    }
    public function text(){
        return $this->hasMany(RealEstateText::class, 'real_estate_id');
    }

    public function titleimage(){
        return $this->morphOne(File::class, 'uploadable');
    }
}
