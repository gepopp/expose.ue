<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RealEstateLocation extends Model
{
    protected $guarded = [];


    public function realEstate(){
        return $this->belongsTo(RealEstate::class);
    }

}
