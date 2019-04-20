<?php


namespace App\pdf;

use App\RealEstate;
use TCPDF;
use Illuminate\Support\Facades\Storage;
use Image;

class TitlepagePDF extends TCPDF
{

    protected $realEstate;



    public function __construct( RealEstate $realEstate,  $orientation = 'L', $unit = 'mm', $size = 'A4' ) {
        $this->realEstate = $realEstate;

        parent::__construct( $orientation, $unit, $size );
        $this->setPrintHeader(false);
        $this->setPrintFooter(false);
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
        $resize = Image::make($image)->fit( (int)((297/2)*3),630)->save( public_path('tmp/') . $this->realEstate->titleimage->name);

        $this->SetRightMargin(0);
        $this->SetAutoPageBreak(false, 0);
        $this->Image(public_path('tmp/' . $this->realEstate->titleimage->name), 149,0, 297/2, null, null, null, null, false  );
        $this->Image(public_path('img/logo-vertikal.png'), 20,50, 108 );
        $this->Image(public_path('img/doties.png'), 0,89.5, null, 40 );

        $this->setXY(20, 140);
        $this->SetFont('helvetica', null, 18 );

        $this->MultiCell(108, 8,  $this->realEstate->name, 0, 'L');

    }

}