<?php


namespace App\pdf;

use App\RealEstate;
use TCPDF;
use Illuminate\Support\Facades\Storage;
use Image;

class MetaPage extends TCPDF
{

    protected $realEstate;
    protected $meta;

    public function __construct( RealEstate $realEstate,  $orientation = 'L', $unit = 'mm', $size = 'A4' ) {
        $this->realEstate = $realEstate;
        $this->meta = $realEstate->meta->first();

        parent::__construct( $orientation, $unit, $size );
        $this->setPrintHeader(false);
        $this->setPrintFooter(false);
    }

    public function firstPage(){

        foreach ($this->realEstate->meta as $meta){
            $this->meta = $meta;
            $this->AddPage();
            $this->titleImage();
        }


    }

    public function get(){
        $this->firstPage();
        $this->Output('test.pdf', 'I');
    }

    public function titleImage(){

        $this->SetTextColor(80,80,80);


        $this->Image(public_path('img/doties-small.png'), 0,5,10, 10 );
        $this->SetFont('helvetica', null, 26 );
        $this->setXY(12, 5.5);
        $this->Cell(150, 10,  $this->meta->name, 0, 'L');


        $image = Storage::get($this->meta->image->path);
        $this->SetMargins(12,0,0);
        $this->SetAutoPageBreak(false, 0);
        $resize = Image::make($image)->fit( (int)((297/2)*3),150*3)->save( public_path('tmp/') . $this->meta->image->name);
        $this->Image(public_path('tmp/' . $this->meta->image->name), 149,30, 297/2, null, null, null, null, false  );
        $this->SetXY(297/2,15);
        $this->SetFont('helvetica', null, 12 );
        $this->Cell(297/2-12, 4, $this->realEstate->name, null, null, 'R');


        $data = json_decode($this->meta->metadata);
        $this->SetXY(12,30);
        $this->SetFont('helvetica', null, 12 );
        $this->SetDrawColor(80,80,80);

        $runner = 1;
        foreach ($data as $datum) {

            if($runner % 2){
                $this->SetFillColor(230,230,230);
            }else{
                $this->SetFillColor(250,250,250);
            }

            $this->Cell(95, 15, $datum->name, null, false, null, 1, null, null, null, null );

            $value = $datum->value;
            if( is_numeric($value) && $datum->format_number){
                $value = number_format($value, 2, ',', '.');
            }
            if($datum->postfix == ''){
                $this->Cell(35, 15, $value, null, true, 'R', 1);
            }else{
                $this->Cell(20, 15, $value, null, false, 'R', 1);
                $this->Cell(15, 15, $datum->postfix, null, true, null, 1);
            }

            $runner++;
        }


        $this->Image(public_path('img/logo-h-20mm.png'), 0,185, null, 10);
        $this->SetDrawColor(203,153,50);
        $this->Line(50,190,285,190);


    }

}