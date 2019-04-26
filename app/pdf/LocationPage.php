<?php


namespace App\pdf;

use App\RealEstate;
use TCPDF;
use Illuminate\Support\Facades\Storage;
use Image;
use App\pdf\PolylineEncoder;

class LocationPage extends TCPDF
{

    protected $realEstate;
    protected $location;

    public function __construct(RealEstate $realEstate, $orientation = 'L', $unit = 'mm', $size = 'A4')
    {
        $this->realEstate = $realEstate;

        parent::__construct($orientation, $unit, $size);
        $this->setPrintHeader(false);
        $this->setPrintFooter(false);
        $this->SetAutoPageBreak(false, 0);
    }

    public function firstPage()
    {

        foreach ($this->realEstate->location as $location) {
            $this->location = $location;
            $this->AddPage();
            $this->titleImage();
        }


    }

    public function get()
    {
        $this->firstPage();
        $this->Output('test.pdf', 'I');
    }

    public function titleImage()
    {

        $this->SetTextColor(80, 80, 80);

        $this->Image(public_path('img/doties-small.png'), 0, 5, 10, 10);
        $this->SetFont('helvetica', null, 26);
        $this->setXY(12, 5.5);
        $this->Cell(150, 10, $this->location->name, 0, 'L');

        $mapUrl = "https://maps.googleapis.com/maps/api/staticmap?center=" . $this->location->lat_lng
                . "&zoom=" . $this->location->zoom
                . "&maptype=" . $this->location->type
                . "&size=445x450&key=AIzaSyADsKyn2Dw9q_cQyxs30OfklCMwOXzhSow";

        if($this->location->marker == "Umkreis"){
            $split = explode(',', $this->location->lat_lng);
            $mapUrl .= '&path=color:0x0000ff00|fillcolor:0xcb993280|enc:' . $this->GMapCircle($split[0], $split[1], ($this->location->radius / 1000));
        }else{
            $mapUrl .= "&markers=color:red,label:*|" . $this->location->lat_lng;
        }

       





        $this->SetMargins(12, 0, 0);
        $this->Image( $mapUrl, 149, 30, 297 / 2, null, null, null, null, false);
        $this->SetXY(297 / 2, 15);
        $this->SetFont('helvetica', null, 12);
        $this->Cell(297 / 2 - 12, 4, $this->realEstate->name, null, null, 'R');

        $this->SetXY(12, 30);
        $this->SetFont('helvetica', null, 12);
        $this->SetDrawColor(80, 80, 80);

        $this->MultiCell(130, 4, $this->location->description, null,null,null,null,12,30,null,null, true);

        $this->Image(public_path('img/logo-h-20mm.png'), 0, 185, null, 10);
        $this->SetDrawColor(203, 153, 50);
        $this->Line(50, 190, 285, 190);


    }



    function GMapCircle($Lat, $Lng, $Rad, $Detail = 2)
    {
        $R = 6371;
        $pi = pi();
        $Lat = ($Lat * $pi) / 180;
        $Lng = ($Lng * $pi) / 180;
        $d = $Rad / $R;
        $points = array();
        for ($i = 0; $i <= 360; $i += $Detail)
        {
            $brng = $i * $pi / 180;
            $pLat = asin(sin($Lat) * cos($d) + cos($Lat) * sin($d) * cos($brng));
            $pLng = (($Lng + atan2(sin($brng) * sin($d) * cos($Lat), cos($d) - sin($Lat) * sin($pLat))) * 180) / $pi;
            $pLat = ($pLat * 180) / $pi;
            $points[] = array($pLat, $pLng);
        }


        $PolyEnc = new PolylineEncoder($points);
        $EncString = $PolyEnc->dpEncode();

        return $EncString['Points'];
    }

}