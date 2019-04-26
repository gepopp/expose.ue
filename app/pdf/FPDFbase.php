<?php


namespace App\pdf;


use TCPDF;


class FPDFbase extends TCPDF
{
    public function __construct($orientation = 'P', $unit = 'mm', $size = 'A4')
    {


        parent::__construct($orientation, $unit, $size);
    }


}