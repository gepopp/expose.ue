<?php


namespace App\pdf;

use App\RealEstate;
use App\RealEstateMeta;
use Faker\Provider\Base;
use TCPDF;
use Illuminate\Support\Facades\Storage;
use Image;

class MetaPage
{

    public function content(BasePdf $pdf, RealEstate $realEstate,  $pageIds = [])
    {

        if(empty($pageIds)){
            foreach($realEstate->meta as $meta){
                if($meta->is_public){
                    $this->addMetaPage($pdf, $meta);
                }
            }
        }else{
            foreach($realEstate->meta as $meta){
                if($meta->is_public && in_array($meta->id, $pageIds)){
                    $this->addMetaPage($pdf, $meta);
                }
            }
        }
        return $pdf;
    }



    public function addMetaPage(BasePdf $pdf, RealEstateMeta $realEstateMeta)
    {
        $data = json_decode($realEstateMeta->metadata);
        $chunks = array_chunk($data, 10);

        $image = Storage::get($realEstateMeta->image->path);
        Image::make($image)->fit((int)((297 / 2) * 3), 150 * 3)->save(public_path('tmp/') . $realEstateMeta->image->name);

        $pdf->setPageTitle( $realEstateMeta->name );

        foreach ($chunks as $chunk){

            $pdf->SetMargins(12, 30);
            $pdf->setPrintHeader(true);
            $pdf->AddPage();
            $pdf->setPrintFooter(true);
            $pdf->SetTextColor(80,80,80);

            $pdf->Image(public_path('tmp/' . $realEstateMeta->image->name), 149, 30, 297 / 2, null, null, null, null, false);

            $pdf->SetXY(12, 30);
            $pdf->SetFont('helvetica', null, 12);

            $runner = 1;
            foreach ($chunk as $datum) {

                if ($runner % 2) {
                    $pdf->SetFillColor(230, 230, 230);
                } else {
                    $pdf->SetFillColor(250, 250, 250);
                }
                $pdf->Cell(95, 15, $datum->name, null, 0, null, 1, null, null, null, null, null);

                $value = $datum->value;
                if (is_numeric($value) && $datum->format_number) {
                    $value = number_format($value, 0, ',', '.');
                }
                $pdf->Cell(20, 15, $value, null, 0, 'R', 1);
                $pdf->Cell(15, 15, $datum->postfix, null, 1, null, 1);
                $runner++;
            }
        }
    }

}