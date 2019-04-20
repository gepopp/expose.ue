<?php


namespace App\pdf;

use App\RealEstate;
use Fpdf\Fpdf;
use TCPDF;
use Illuminate\Support\Facades\Storage;
use Image;

class ObjectDescription extends TCPDF
{



    protected $realEstate;

    public function __construct(RealEstate $realEstate, $orientation = 'L', $unit = 'mm', $size = 'A4')
    {
        $this->realEstate = $realEstate;
        parent::__construct($orientation, $unit, $size);
        $this->setPrintFooter(false);
        $this->setPrintHeader(false);
        $this->SetAutoPageBreak(false, 0);
    }

    public function firstPage()
    {

        $this->AddPage();
        $this->content();

    }

    public function get()
    {
        $this->firstPage();
        $this->Output('test.pdf', 'I');
    }

    public function content()
    {
        $this->SetAutoPageBreak(false);

        $this->Image(public_path('img/pdf-header-logo.png'), 0, 3);
        $this->SetLineWidth(.5);
        $this->SetDrawColor(164, 103, 52);
        $this->Line(20, 190, 277, 190);
        $this->SetFont('helvetica', null, 16);

        $this->SetXY(25,40);
        $this->Cell(247, 10, $this->realEstate->name);

        $this->SetFont('helvetica', null, 10);
        $this->SetXY(25,50);
        $this->SetMargins(25,40,25);
        $this->MultiCell(247, 6, $this->realEstate->description, 0, 'L', 0, null, 25, 50, null, 0, true);

        $this->SetXY(25, 191);
        $this->Cell(247 / 4, 4, 'Mag. Doris Uehlein', null, 0, 'L');
        $this->Cell(247 / 4, 4, 'Pappenheimgasse 58/6', 0, 0, 'C');
        $this->Cell(247 / 4, 4, 'Limburgerstraße 3a', 0, 0, 'C');
        $this->Cell(247 / 4, 4, 'M +43 699 166 907 20', 0, 1, 'R', 0);

        $this->SetX(25);
        $this->Cell(247 / 4, 4, 'uehlein@uehlein.at', null, 0, 'L');
        $this->Cell(247 / 4, 4, 'A-1200 Wien', 0, 0, 'C');
        $this->Cell(247 / 4, 4, 'DE-04229 Leipzig', 0, 0, 'C');
        $this->Cell(247 / 4, 4, 'T  +43 1 330 399 7', 0, 1, 'R', 0);

        $this->SetX(25);
        $this->Cell(247 / 4, 4, 'https://www.uehlein.at', null, 0, 'L');
        $this->Cell(247 / 4, 4, '', 0, 0, 'C');
        $this->Cell(247 / 4, 4, '', 0, 0, 'C');
        $this->Cell(247 / 4, 4, 'T  +49 341 247 274 73', 0, 1, 'R', 0);


    }




}