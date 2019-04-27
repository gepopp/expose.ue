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
        $pdf->SetAutoPageBreak(true, 30);
        $pdf->AddPage();
        $pdf->setPrintFooter(true);


        $image = Storage::get($realEstateText->image->path);
        $resize = Image::make($image)->fit((int)((297 / 2) * 3), 150 * 3)->save(public_path('tmp/') . $realEstateText->image->name);
        $pdf->setPageBreakImage(public_path('tmp/' . $realEstateText->image->name));
        $pdf->Image(public_path('tmp/' . $realEstateText->image->name), 149, 30, 297 / 2, null, null, null, null, false);


        $pdf->SetFont('helvetica', null, 12);
        $pdf->MultiCell(130, 4, $realEstateText->description, 0, 'J', 0, 2, '', 30, true, 0, true, true, null, 'T');

    }

}