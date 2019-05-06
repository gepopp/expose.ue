<?php


namespace App\pdf;

use App\RealEstate;
use Illuminate\Support\Facades\Storage;
use Image;

class TitlePage
{


    public function content( BasePdf $pdf, RealEstate $realEstate){

        $pdf->SetRightMargin(0);
        $pdf->SetLeftMargin(0);
        $pdf->SetAutoPageBreak(false, 0);

        $pdf->setPrintHeader(false);

        $pdf->AddPage();
        $pdf->setPrintFooter(false);

        $pdf->Image(Storage::url($realEstate->titleimage->path), 0,0, 297, 210/2 + 30, null, null, null, true  );

        $pdf->Image(public_path('img/doties.png'), 0,210/2 + 40, null, 30 );
        $pdf->Image(public_path('img/doties.png'), 12,210/2 + 40, null, 30 );
        $pdf->Image(public_path('img/logo-vertikal.png'), 30,210/2+40, null, 30 );

        $pdf->Rect(297/2, 210/2+40, 297/2, 30, 'F', 0, [203, 153, 50]);

        $pdf->SetXY(297/2+5, 210/2+45 );
        $pdf->SetFont('helvetica', null, 18);
        $pdf->SetTextColor(255,255,255);
        $pdf->Cell(297/2-10, 8, $realEstate->name, null, 1, 'L', null, null, 1, null, null, null);
        $pdf->SetFontSize(12);
        $pdf->SetDrawColor(255,255,255);

        $address = $realEstate->description;

        if( $realEstate->show == 1 ){
            $address = $realEstate->country . '-' . $realEstate->zip . ' ' . $realEstate->city;
        }
        if($realEstate->show == 2){
            $address = $realEstate->street . '<br>' . $realEstate->country . '-' . $realEstate->zip . ' ' . $realEstate->city;
        }
        if($realEstate->show == 3){
            $address = $realEstate->street . ' ' . $realEstate->number .  '<br>' . $realEstate->country . '-' . $realEstate->zip . ' ' . $realEstate->city;
        }




        $pdf->MultiCell(297/2-10, 10, $address, 1, 'L', 1, 1, 297/2+5, 210/2+55, true, 0, true, true, 60, 'M', true);

        return $pdf;

    }

}