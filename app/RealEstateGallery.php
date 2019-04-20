<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RealEstateGallery extends Model
{
    protected $guarded = [];

    protected $with =['files'];


    public function realEstate(){

        return $this->belongsTo(RealEstate::class);

    }

    public function files(){
        return $this->hasMany(File::class);
    }

}
