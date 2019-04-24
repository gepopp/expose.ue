<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RealEstateMeta extends Model
{
    protected $guarded = [];

    public function image(){
        return $this->morphOne(File::class, 'uploadable');
    }
}
