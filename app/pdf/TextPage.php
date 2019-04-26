<?php


namespace App\pdf;

use App\RealEstate;
use TCPDF;
use Illuminate\Support\Facades\Storage;
use Image;

class TextPage extends TCPDF
{

    protected $realEstate;
    protected $text;

    public function __construct(RealEstate $realEstate, $orientation = 'L', $unit = 'mm', $size = 'A4')
    {
        $this->realEstate = $realEstate;
        $this->text = $realEstate->text->first();

        parent::__construct($orientation, $unit, $size);
        $this->setPrintHeader(false);
        $this->setPrintFooter(false);
    }

    public function firstPage()
    {

        foreach ($this->realEstate->text as $text) {
            $this->text = $text;
            $this->AddPage();
            $this->titleImage();
        }


    }

    public function get()
    {
        $this->firstPage();
        $this->Output('test.pdf', 'I');
    }

    public function titleImage()
    {

        $this->SetTextColor(80, 80, 80);


        $this->Image(public_path('img/doties-small.png'), 0, 5, 10, 10);
        $this->SetFont('helvetica', null, 26);
        $this->setXY(12, 5.5);
        $this->Cell(150, 10, $this->text->name, 0, 'L');


        $image = Storage::get($this->text->image->path);
        $this->SetMargins(12, 0, 0);
        $this->SetAutoPageBreak(false, 0);
        $resize = Image::make($image)->fit((int)((297 / 2) * 3), 150 * 3)->save(public_path('tmp/') . $this->text->image->name);
        $this->Image(public_path('tmp/' . $this->text->image->name), 149, 30, 297 / 2, null, null, null, null, false);
        $this->SetXY(297 / 2, 15);
        $this->SetFont('helvetica', null, 12);
        $this->Cell(297 / 2 - 12, 4, $this->realEstate->name, null, null, 'R');


        $this->SetXY(12, 30);
        $this->SetFont('helvetica', null, 12);
        $this->SetDrawColor(80, 80, 80);

        $this->MultiCell(130, 4, $this->text->description, null,null,null,null,12,30,null,null, true);

        $this->Image(public_path('img/logo-h-20mm.png'), 0, 185, null, 10);
        $this->SetDrawColor(203, 153, 50);
        $this->Line(50, 190, 285, 190);


    }

}