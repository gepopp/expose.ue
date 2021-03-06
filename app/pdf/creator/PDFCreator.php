<?php


namespace App\pdf\creator;


use App\pdf\BasePdf;
use App\RealEstate;
use Faker\Provider\Base;
use Illuminate\Http\Request;

class PDFCreator
{

    protected $realEstate;

    public function SortNSelect(RealEstate $realEstate)
    {


        return view('pdf.sortselect')->with('realEstate', $realEstate);

    }


    public function create(Request $request, RealEstate $realEstate)
    {

        $pdf = new BasePdf($realEstate);
        foreach ($request->all() as $page_to_add) {

            if ($page_to_add['print']) {
                $class = 'App\pdf\\' . $page_to_add['object'];
                $page = new $class;
                $pdf = $page->content($pdf, $realEstate, [$page_to_add['id']]);
                $this->cleanTmp();
            }
        }
        $time = time();

        $pdf->Output(public_path('tmp/' . $time . '.pdf'), 'F');
        return '/tmp/' . $time . '.pdf';

    }


    public function singlePage(RealEstate $realEstate, $page)
    {

        $pdf = new BasePdf($realEstate);
        $class = 'App\pdf\\' . $page;
        $page = new $class;
        $pdf = $page->content($pdf, $realEstate);

        $pdf->Output(time() . '.pdf', 'I');
        $this->cleanTmp();


    }


    public function cleanTmp()
    {

        foreach (glob(public_path('tmp/*')) as $file) {
            if (file_exists($file) && !strpos($file, 'index')) {
                unlink($file);
            }
        }

    }


}