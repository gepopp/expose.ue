<?php


namespace App\pdf;


use Fpdf\Fpdf;

class FPDFbase extends Fpdf
{
    public function __construct($orientation = 'P', $unit = 'mm', $size = 'A4')
    {
        parent::__construct($orientation, $unit, $size);
    }
    public function Cell($w, $h = 0, $txt = '', $border = 0, $ln = 0, $align = '', $fill = false, $link = '')
    {
        $txt = iconv(mb_detect_encoding($txt), 'ISO-8859-1', $txt);
        parent::Cell($w, $h, $txt, $border, $ln, $align, $fill, $link); // TODO: Change the autogenerated stub
    }
    public function MultiCell($w, $h, $txt, $border = 0, $align = 'J', $fill = false)
    {
        $txt = iconv(mb_detect_encoding($txt), 'ISO-8859-1', $txt);
        parent::MultiCell($w, $h, $txt, $border, $align, $fill); // TODO: Change the autogenerated stub
    }

}