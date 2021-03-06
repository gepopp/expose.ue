<?php


namespace App\pdf;

use App\RealEstate;
use App\RealEstateText;
use TCPDF;
use Illuminate\Support\Facades\Storage;
use Image;

class TextPage
{


    public function content(BasePdf $pdf, RealEstate $realEstate, $pageIds = [])
    {

        if (empty($pageIds)) {
            foreach ($realEstate->text as $text) {
                if ($text->is_public) {
                    $this->addTextPage($pdf, $text);
                }
            }
        } else {
            foreach ($realEstate->text as $text) {
                if ($text->is_public && in_array($text->id, $pageIds)) {
                    $this->addTextPage($pdf, $text);
                }
            }
        }
        return $pdf;
    }

    public function addTextPage(BasePdf $pdf, RealEstateText $realEstateText)
    {
        $pdf->setPrintHeader(true);
        $pdf->SetTextColor(80,80,80);


        $pdf->setPageTitle($realEstateText->name);

        $pdf->SetMargins(12, 30);
        $pdf->SetAutoPageBreak(true, 10);
        $pdf->AddPage();
        $pdf->setPrintFooter(true);

        $pdf->setPageBreakImage(Storage::url( $realEstateText->image->path ));
        $pdf->Image(Storage::url( $realEstateText->image->path ), 149, 30, 297 / 2, null, null, null, null, false);

        $pdf->SetFont('helvetica', null, 12);
        $pdf->MultiCell(130, 4, $realEstateText->description, 0, 'J', 0, 2, '', 30, true, 0, true, true, null, 'T');

    }

}
