<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RealEstate extends Model
{
    protected $guarded = [];

    protected $with = ['titleimage'];


    public function titleimage(){

        return $this->hasOne(File::class, 'id', 'titleimage_id');

    }
}
