<?php


namespace App\pdf;


use App\File;
use App\RealEstate;
use Illuminate\Support\Facades\Storage;
use TCPDF;
use Image;


class BasePdf extends TCPDF
{

    protected $realEstate;
    protected $pageTitle = 'Uehlein Immobilien';
    protected $pageBreakImage;

    /**
     * @param mixed $pageBreakImage
     */
    public function setPageBreakImage( $pageBreakImage ): void
    {
        $this->pageBreakImage = $pageBreakImage;
    }

    /**
     * @param string $pageTitle
     */
    public function setPageTitle(string $pageTitle): void
    {
        $this->pageTitle = $pageTitle;
    }


    public function __construct(RealEstate $realEstate, $orientation = 'L', $unit = 'mm', $size = 'A4')
    {

        $this->realEstate = $realEstate;
        parent::__construct($orientation, $unit, $size);
        $this->addFont('Kartika', '', public_path('font/Kartika.php'));
        $this->SetFont('Kartika', '', 9, '', 'true');
        $this->SetTextColor(80, 80, 80);


    }

    public function Header()
    {
        /* Page Title */
        $this->Image(public_path('img/doties-small.png'), 0, 5, 10, 10);
        $this->SetFont('Kartika', null, 32);
        $this->setXY(12, 5.5);
        $this->Cell(150, 10, $this->pageTitle, 0, 'L');


        /* Real Estate Title on the right */
        $this->SetXY(297 / 2, 11);
        $this->SetFont('helvetica', null, 12);
        $this->Cell(297 / 2 - 12, 4, $this->realEstate->name, null, null, 'R');
    }

    public function Footer()
    {
        $this->Image(public_path('img/logo-h-20mm.png'), 0, 185, null, 10);
        $this->SetDrawColor(203, 153, 50);
        $this->Line(50, 190, 285, 190);

    }

    public function AcceptPageBreak()
    {
        if($this->pageBreakImage && $this->AutoPageBreak){

            $this->AddPage();
            $this->Image($this->pageBreakImage, 149, 30, 297 / 2);
            return false;
        }
        return parent::AcceptPageBreak();
    }


}