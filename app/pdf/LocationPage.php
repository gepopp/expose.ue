<?php


namespace App\pdf;

use App\RealEstate;
use App\RealEstateLocation;
use Faker\Provider\Base;
use TCPDF;
use Illuminate\Support\Facades\Storage;
use Image;
use App\pdf\helper\PolylineEncoder;

class   LocationPage
{

    public function content(BasePdf $pdf, RealEstate $realEstate,  $pageIds = [])
    {

        if(empty($pageIds)){
            foreach($realEstate->location as $locatiom){
                if($locatiom->is_public){
                    $this->addLocationPage($pdf, $locatiom);
                }
            }
        }else{
            foreach($realEstate->location as $locatiom){
                if($locatiom->is_public && in_array($locatiom->id, $pageIds)){
                    $this->addLocationPage($pdf, $locatiom);
                }
            }
        }
        return $pdf;
    }



    public function addLocationPage(BasePdf $pdf, RealEstateLocation $realEstateLocation)
    {
        $pdf->setPrintHeader(true);
        $pdf->setPrintFooter(true);
        $pdf->SetTextColor(80,80,80);

        $pdf->setPageTitle( $realEstateLocation->name );

        $pdf->SetMargins(12, 30);
        $pdf->SetAutoPageBreak(true, 30);

        $pdf->AddPage();

        $mapUrl = "https://maps.googleapis.com/maps/api/staticmap?center=" . $realEstateLocation->lat_lng
                . "&zoom=" . $realEstateLocation->zoom
                . "&maptype=" . $realEstateLocation->type
                . "&size=445x450&key=AIzaSyADsKyn2Dw9q_cQyxs30OfklCMwOXzhSow";

        if($realEstateLocation->marker == "Umkreis"){
            $split = explode(',', $realEstateLocation->lat_lng);
            $mapUrl .= '&path=color:0x0000ff00|fillcolor:0xcb993280|enc:' . $this->GMapCircle($split[0], $split[1], ($realEstateLocation->radius / 1000));
        }else{
            $mapUrl .= "&markers=color:0xcb9932|" . $realEstateLocation->lat_lng;
        }

        $image_path = public_path('tmp/') . time() . '.jpg';

        Image::make($mapUrl)->fit((int)((297 / 2) * 3), 150 * 3)->save($image_path)->encode('jpg', 80);

        $pdf->setPageBreakImage($image_path);

        $pdf->Image( $image_path, 149, 30, 297 / 2, null, null, null, null, false);

        $pdf->SetXY(12, 30);
        $pdf->SetFont('helvetica', null, 12);
        $pdf->SetDrawColor(80, 80, 80);
        $pdf->MultiCell(130, 4, $realEstateLocation->description, 0, 'L', 0, 1, 12, 30, true, 0, true, true, null, 'T');

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