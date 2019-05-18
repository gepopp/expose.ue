<?php


namespace App\pdf;


use App\RealEstate;
use App\TextSnippet;
use App\User;
use Illuminate\Support\Facades\Auth;

class SnippetPage
{

    public function content(BasePdf $pdf, RealEstate $realEstate, $pageIds = [])
    {
        $snippets = Auth::user()->textSnippets;
        if (empty($pageIds)) {
            foreach ($snippets as $snippet) {
                if ($snippet->use_as_page) {
                    $this->addSnippetPage($pdf, $snippet);
                }
            }
        } else {
            foreach ($snippets as $snippet) {
                if ($snippet->use_as_page && in_array($snippet->id, $pageIds)) {
                    $this->addSnippetPage($pdf, $snippet);
                }
            }
        }
        return $pdf;
    }


    public function addSnippetPage(BasePdf $pdf, TextSnippet $textSnippet)
    {


        $pdf->setPrintHeader(true);
        $pdf->SetTextColor(80,80,80);


        $pdf->setPageTitle($textSnippet->title);

        $pdf->SetMargins(12, 20);
        $pdf->SetAutoPageBreak(true, 30);
        $pdf->AddPage();
        $pdf->setPrintFooter(true);


        $pdf->SetFont('helvetica', null, 12);
        $pdf->SetTextColor(80,80,80);

        $sidebar =  Auth::user()->settings()->where('name', 'sidebar-text')->first();

        $pdf->Image(public_path('img/logo.png'), ((297-24)/3)*2+20, 30, (287/3)-20 );

        $pdf->MultiCell(((297-24)/3)*2, 4, $textSnippet->text, 0, 'J', 0, 2, '', 30, true, 0, true, true, null, 'T');
        $pdf->SetFont('helvetica', null, 10);
        $pdf->MultiCell(((297-24)/3)*2-38, 4, $sidebar->setting, 0, 'J', 0, 2, ((297-24)/3)*2+36, 48, true, 0, true, true, null, 'T');

    }
}