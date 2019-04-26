<?php


namespace App\pdf;

use App\RealEstate;
use TCPDF;
use Illuminate\Support\Facades\Storage;
use Image;

class ImagePage extends TCPDF
{

    protected $realEstate;
    protected $gallery;

    public function __construct(RealEstate $realEstate, $orientation = 'L', $unit = 'mm', $size = 'A4')
    {
        $this->realEstate = $realEstate;

        parent::__construct($orientation, $unit, $size);
        $this->setPrintHeader(false);
        $this->setPrintFooter(false);
        $this->SetAutoPageBreak(false, 0);
        $this->addFont('Kartika', '', public_path('font/Kartika.php'));
        $this->SetFont('Kartika', '', 9, '', 'true');

    }

    public function firstPage()
    {

        foreach ($this->realEstate->gallery as $gallery) {
            $this->gallery = $gallery;
            $this->AddPage();
            $this->titleImage();
        }


    }

    public function get()
    {
        $this->firstPage();
        $this->Output('test.pdf', 'I');
    }

    public function titleImage($images = null)
    {

        $this->SetTextColor(80, 80, 80);


        $this->Image(public_path('img/doties-small.png'), 0, 5, 10, 10);
        $this->SetFont('Kartika', null, 32);
        $this->setXY(12, 5.5);
        $this->Cell(150, 10, $this->gallery->name, 0, 'L');
        $this->SetXY(297 / 2, 15);
        $this->SetFont('helvetica', null, 12);
        $this->Cell(297 / 2 - 12, 4, $this->realEstate->name, null, null, 'R');


        if(!$images){
            $images = $this->gallery->images;
        }

        $max = count($images) > 4 ? 4 : count($images);
        for ($i = 1; $i <= $max; $i++) {

            $imgData = $images->shift();

            $image = Storage::get($imgData->path);
            $resize = Image::make($image)->fit((int)400, 300)->save(public_path('tmp/') . $imgData->name);
            $leftCorner = [[46, 25], [151, 25], [46, 105], [151, 105]];
            $this->Image(public_path('tmp/' .$imgData->name), $leftCorner[$i-1][0], $leftCorner[$i-1][1], 100, null, null, null, null, false);

            if($imgData->alt != ''){
                $this->SetFillColor(0,0,0 );
                $this->SetAlpha(0.5);
                $this->SetFontSize(12);
                $this->SetTextColor(255,255,255);
                $this->SetXY($leftCorner[$i-1][0] , $leftCorner[$i-1][1]+ 68);
                $this->Cell(100,7, $imgData->alt, null, null, 'C', true, null, 1);
                $this->SetAlpha(1);
                $this->SetXY($leftCorner[$i-1][0] , $leftCorner[$i-1][1]+ 68);
                $this->SetTextColor(255,255,255);
                $this->Cell(100,7, $imgData->alt, null, null, 'C', false, null, 1);

            }
        }


        $this->Image(public_path('img/logo-h-20mm.png'), 0, 185, null, 10);
        $this->SetDrawColor(203, 153, 50);
        $this->Line(50, 190, 285, 190);

        if(count($images) > 0){
            $this->AddPage();
            $this->titleImage($images);

        }
    }

}