<?php

namespace App\Http\Controllers;

use App\RealEstate;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $realEstates = RealEstate::all();
        return view('home')->with(['realEstates' => $realEstates]);
    }
}
