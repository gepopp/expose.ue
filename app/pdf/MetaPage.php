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

    public function content(BasePdf $pdf, RealEstate $realEstate, $pageIds = [])
    {

        if (empty($pageIds)) {
            foreach ($realEstate->meta as $meta) {
                if ($meta->is_public) {
                    $this->addMetaPage($pdf, $meta);
                }
            }
        } else {
            foreach ($realEstate->meta as $meta) {
                if ($meta->is_public && in_array($meta->id, $pageIds)) {
                    $this->addMetaPage($pdf, $meta);
                }
            }
        }
        return $pdf;
    }


    public function addMetaPage(BasePdf $pdf, RealEstateMeta $realEstateMeta)
    {

        $pdf->setPageTitle($realEstateMeta->name);
        $pdf->setPageBreakImage(Storage::url($realEstateMeta->image->path));
        $pdf->SetMargins(12, 30);
        $pdf->setPrintHeader(true);
        $pdf->setPrintFooter(true);
        $pdf->SetTextColor(80, 80, 80);

        $data = json_decode($realEstateMeta->metadata);
        $chunks = array_chunk($data, 20);

        $pdf->SetFont('helvetica', null, 12);
        $pdf->SetFillColor(230, 230, 230);

        foreach ($chunks as $chunk) {

            $pdf->AddPage();
            $pdf->SetXY(12, 30);

            if (count($chunk) > 10) {

                $runner = 1;

                foreach ($chunk as $datum) {

                    $pdf->Cell(95, 15, $datum->name, null, 0, null, 1, null, null, null, null, null);
                    $value = $datum->value;
                    $pdf->Cell(35, 15, $value . ' ' . $datum->postfix, null, 0, 'R', 1);


                    if ($runner % 2 == 0) {
                        $pdf->Ln(15);
                        if ($runner % 4 == 0) {
                            $pdf->SetFillColor(230, 230, 230);
                        } else {
                            $pdf->SetFillColor(250, 250, 250);
                        }
                    } else {
                        $pdf->Cell(12, 15, '', 0, 0, null, 0);
                    }
                    $runner++;
                }
            } else {
                $runner = 1;
                foreach ($chunk as $datum) {

                    if ($runner % 2) {
                        $pdf->SetFillColor(230, 230, 230);
                    } else {
                        $pdf->SetFillColor(250, 250, 250);
                    }
                    $pdf->Cell(95, 15, $datum->name, null, 0, null, 1, null, null, null, null, null);
                    $value = $datum->value;
                    $pdf->Cell(35, 15, $value . ' ' . $datum->postfix, null, 1, 'R', 1);
                    $runner++;
                }
                $pdf->Image(Storage::url($realEstateMeta->image->path), 149, 30, 297 / 2, null, null, null, null, false);
            }
        }
    }

}