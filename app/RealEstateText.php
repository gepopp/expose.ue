<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\File;

class RealEstateText extends Model
{
    protected $guarded = [];
    protected $with = ['image'];


    public function image(){
        return $this->morphOne( File::class, 'uploadable' );
    }

}
