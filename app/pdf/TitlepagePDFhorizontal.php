<?php


namespace App\pdf;

use App\RealEstate;
use Fpdf\Fpdf;
use Illuminate\Support\Facades\Storage;
use Image;

class TitlepagePDFhorizontal extends Fpdf
{

    protected $realEstate;

    public function __construct( RealEstate $realEstate,  $orientation = 'L', $unit = 'mm', $size = 'A4' ) {
        $this->realEstate = $realEstate;

        parent::__construct( $orientation, $unit, $size );
    }

    public function firstPage(){

        $this->AddPage();
        $this->titleImage();

    }

    public function get(){
        $this->firstPage();
        $this->Output('test.pdf', 'I');
    }

    public function titleImage(){

        $image = Storage::get($this->realEstate->titleimage->path);
        $resize = Image::make($image)->fit( (int)((297)*3), (210/2)*3)->save( public_path('tmp/') . $this->realEstate->titleimage->name);

        $this->Image(public_path('tmp/' . $this->realEstate->titleimage->name), 0,20,297, 105 );


        $this->Image(public_path('img/doties.png'), 0,145, null,  40 );
        $this->Image(public_path('img/doties.png'), 16,145, null,  40 );
        $this->Image(public_path('img/logo-vertikal.png'), 40,145, null, 40 );


        $this->SetFillColor( 204,153,51);
        $this->Rect(297/2, 145, 297/2, 40, 'F' );


        $this->setXY(297/2 + 5, 150);
        $this->SetTextColor(255,255,255);
        $this->SetFont('helvetica', null, 18 );
        $this->MultiCell((297/2)-10, 8,  iconv('UTF-8', 'windows-1252',$this->realEstate->name), 0, 'R');

    }

}