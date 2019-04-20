<?php


namespace App\pdf;

use App\RealEstate;
use Fpdf\Fpdf;
use Illuminate\Support\Facades\Storage;
use Image;

class TitlepagePDFLogoSmall extends FPDFbase
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

        $this->Image(public_path('img/pdf-header-logo.png'), 0, 180);

        $this->SetFont('helvetica', null, 22);
        $this->SetXY(0,150);
        $this->MultiCell(297, 8, $this->realEstate->name, 0, 'C');

    }

}