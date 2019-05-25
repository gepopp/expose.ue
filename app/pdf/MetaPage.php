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
        $pdf->SetFont('helvetica', null, 12);
        $pdf->SetFillColor(230, 230, 230);

        $leftCol = [];
        $rightCol = [];

        foreach ($data as $datum) {
            if (!isset($datum->column) || $datum->column == 'left') {
                $leftCol[] = $datum;
            } else {
                $rightCol[] = $datum;
            }
        }

        $this->page($pdf, $leftCol, $rightCol, $realEstateMeta->image->path);

    }


    public function page( BasePdf $pdf, $leftCol, $rightCol, $image)
    {

        $pdf->AddPage();
        $pdf->SetXY(12, 30);

        if (count($leftCol) && count($rightCol)) {
            $this->twoColumns($leftCol, $rightCol, $pdf, $image);
        } else {
            $pdf->SetAutoPageBreak(true, 30);
            $this->oneColumn( $leftCol, $rightCol, $pdf, $image);
        }

    }

    public function oneColumn($leftCol, $rightCol, $pdf, $image)
    {
        $runner = 1;

        $data = array_merge($leftCol, $rightCol);

        $pdf->Image(Storage::url($image), 149, 30, 297 / 2, null, null, null, null, false);

        foreach ($data as $datum) {

            if ($runner % 2) {
                $pdf->SetFillColor(230, 230, 230);
            } else {
                $pdf->SetFillColor(250, 250, 250);
            }
            $pdf->SetX(12);
            $pdf->Cell(95, 15, $datum->name, null, 0, null, 1, null, null, null, null, null);
            $value = $datum->value;
            $pdf->Cell(35, 15, $value . ' ' . $datum->postfix, null, 1, 'R', 1);
            $runner++;
        }
    }


    public function twoColumns($leftCol, $rightCol, $pdf, $image)
    {
        $runner = 1;
        while ($this->linesToInsert($leftCol, $rightCol)) {

            if ($runner > 10) {
                $this->page($pdf, $leftCol, $rightCol, $image);
                break;
            }


            if ($runner % 2 == 0) {
                $pdf->SetFillColor(230, 230, 230);
            } else {
                $pdf->SetFillColor(250, 250, 250);
            }


            if (count($leftCol)) {
                $data = array_shift($leftCol);
                $pdf->SetX(12);
                $pdf->Cell(95, 15, $data->name, null, 0, null, 1, null, null, null, null, null);
                $pdf->Cell(35, 15, $data->value . ' ' . $data->postfix, null, 0, 'R', 1);
            }
            if (count($rightCol)) {
                $data = array_shift($rightCol);
                $pdf->SetX(154);
                $pdf->Cell(95, 15, $data->name, null, 0, null, 1, null, null, null, null, null);
                $pdf->Cell(35, 15, $data->value . ' ' . $data->postfix, null, 0, 'R', 1);
            }
            $pdf->Ln(15);
            $runner++;
        }
    }


    public function linesToInsert($left, $right)
    {
        return max(count($left), count($right));
    }

}