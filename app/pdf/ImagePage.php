<?php


namespace App\pdf;

use App\RealEstate;
use App\RealEstateGallery;
use Faker\Provider\Base;
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
        $chunks = $realEstateGallery->images->chunk(3);

        foreach($chunks as $chunk){


            $pdf->setPageTitle($realEstateGallery->name);

            $pdf->setPrintHeader(true);
            $pdf->AddPage();
            $pdf->setPrintFooter(true);

            if(count($chunk) == 3){
                $this->threeImages($chunk, $pdf, $realEstateGallery->description);
            }
            if(count($chunk) == 2){
                $this->twoImages($chunk, $pdf, $realEstateGallery->description);
            }
            if(count($chunk) == 1){
                $this->oneImage($chunk, $pdf, $realEstateGallery->description);
            }
        }
    }

    public function threeImages($chunk, BasePdf $pdf, $description = ""){

        $pdf->SetFillColor(203, 153, 50);
        $pdf->SetTextColor(255,255,255);
        $pdf->SetFont('helvetica', null, 12);
        $pdf->Rect(115, 164, 170, 17.5, 'F',0,[203,153,50]);
        $pdf->MultiCell(164,11.5, $description, 0, 'L', true, 0, 118, 167, true, 0, true, false, 0, 'M', true);


        $corners = [ [12,30], [12,110], [115,30] ];
        $w = [93,93, 170];

        $i = 0;
        foreach($chunk as $image){
            $pdf->Image(Storage::url($image->path), $corners[$i][0], $corners[$i][1], $w[$i], (($w[$i]/4)*3), null, null, null, false);
            $i++;
        }
    }

    public function twoImages($chunk, BasePdf $pdf, $description = ""){


        $pdf->SetFillColor(203, 153, 50);
        $pdf->SetTextColor(255,255,255);
        $pdf->SetFont('helvetica', null, 12);
        $pdf->Rect(115, 164, 170, 17.5, 'F',0,[203,153,50]);
        $pdf->MultiCell(164,11.5, $description, 0, 'L', true, 0, 118, 167, true, 0, true, false, 0, 'M', true);

        $corners = [ [12,30], [153.5,30] ];
        $w = 131.5;

        $i = 0;
        foreach($chunk as $image){
            $pdf->Image(Storage::url($image->path), $corners[$i][0], $corners[$i][1], $w, (($w/4)*3), null, null, null, false);
            $i++;
        }
    }

    public function oneImage($chunk, BasePdf $pdf, $description = ""){



        $image = $chunk->shift();
        $pdf->Image(Storage::url($image->path), 48.5, 30 , 200, 150, null, null, null, false);

//        $pdf->SetFillColor(203, 153, 50);
//        $pdf->SetTextColor(255,255,255);
//        $pdf->SetFont('helvetica', null, 12);
//        $pdf->Rect(78.5, 164, 170, 17.5, 'F',0,[203,153,50]);
//        $pdf->MultiCell(164,11.5, $description, 0, 'L', true, 0, 81.5, 167, true, 0, true, false, 0, 'M', true);


    }

}