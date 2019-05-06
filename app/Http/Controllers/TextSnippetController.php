<?php

namespace App\Http\Controllers;

use App\TextSnippet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TextSnippetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $snippets = Auth::user()->textSnippets;
        return view('snippets.index')->with('textSnippets', $snippets);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('snippets.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
           'title' => 'required',
           'text' => 'required',
        ]);

        TextSnippet::create([
           'user_id' => Auth::user()->id,
           'title' => $request->title,
           'use_as_page' => $request->use_as_page ?: 0,
           'text' => $request->text
        ]);

        return redirect(route('textSnippet.index'));


    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\TextSnippet  $textSnippet
     * @return \Illuminate\Http\Response
     */
    public function edit(TextSnippet $textSnippet)
    {
        return view('snippets.edit')->with('textSnippet', $textSnippet);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\TextSnippet  $textSnippet
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TextSnippet $textSnippet)
    {
        $request->validate([
            'title' => 'required',
            'text' => 'required'
        ]);

       $textSnippet->update([
            'title' => $request->title,
            'use_as_page' => $request->use_as_page ?: 0,
            'text' => $request->text
        ]);

        return redirect(route('textSnippet.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\TextSnippet  $textSnippet
     * @return \Illuminate\Http\Response
     */
    public function destroy(TextSnippet $textSnippet)
    {
        //
    }
}
