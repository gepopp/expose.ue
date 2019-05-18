<?php


namespace App\pdf;

use App\RealEstate;
use App\RealEstateGallery;
use TCPDF;
use Illuminate\Support\Facades\Storage;
use Image;

class ImagePage
{

    public function content(BasePdf $pdf, RealEstate $realEstate,  $pageIds = [])
    {

        if(empty($pageIds)){
            foreach($realEstate->gallery as $gallery){
                if($gallery->is_public){
                    $this->addGalleryPage($pdf, $gallery);
                }
            }
        }else{
            foreach($realEstate->gallery as $gallery){
                if($gallery->is_public && in_array($gallery->id, $pageIds)){
                    $this->addGalleryPage($pdf, $gallery);
                }
            }
        }
        return $pdf;
    }

    public function addGalleryPage(BasePdf $pdf, RealEstateGallery $realEstateGallery)
    {
        $pdf->SetTextColor(80,80,80);
        $pdf->SetAutoPageBreak(false, 0);
        $chunks = $realEstateGallery->images->chunk(4);

        foreach ($chunks as $chunk) {
            $pdf->setPageTitle($realEstateGallery->name);
            $pdf->setPrintHeader(true);

            $pdf->AddPage();
            $pdf->setPrintFooter(true);

            foreach ($chunk as $i => $imgData) {

                $image = Storage::get($imgData->path);
                Image::make($image)->fit((int)400 *3, 300 * 3)->save(public_path('tmp/') . $imgData->name);

                $w = count($chunk) > 1 ? 100 : (297 - (46*2));
                $leftCorner = [[46, 25], [151, 25], [46, 105], [151, 105]];
                $pdf->Image(public_path('tmp/' .$imgData->name), $leftCorner[$i][0], $leftCorner[$i][1], $w, null, null, null, null, false);

                if($imgData->alt != ''){

                    $i = count($chunk) > 1 ? $i : 2;

                    $pdf->SetFillColor(0,0,0 );
                    $pdf->SetAlpha(0.5);
                    $pdf->SetFontSize(12);
                    $pdf->SetTextColor(255,255,255);
                    $pdf->SetXY($leftCorner[$i][0] , $leftCorner[$i][1]+ 68);
                    $pdf->Cell($w,7, $imgData->alt, null, null, 'C', true, null, 1);
                    $pdf->SetAlpha(1);
                    $pdf->SetXY($leftCorner[$i][0] , $leftCorner[$i][1]+ 68);
                    $pdf->SetTextColor(255,255,255);
                    $pdf->Cell($w,7, $imgData->alt, null, null, 'C', false, null, 1);

                }


            }
        }
    }
}