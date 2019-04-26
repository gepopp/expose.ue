<?php


namespace App\pdf\creator;


use App\RealEstate;

class PDFCreator
{

    protected $realEstate;

    public function SortNSelect(RealEstate $realEstate){


        return view('pdf.sortselect')->with('realEstate', $realEstate);

    }






}