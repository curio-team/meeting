<?php

namespace App\Http\Controllers;

use App\Suggestion;
use Illuminate\Http\Request;

class SuggestionController extends Controller
{

    public function index()
    {
        return view('suggestions.index')->with('suggestions', Suggestion::all());
    }

    public function create()
    {
        return view('suggestions.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'term' => 'required|integer|between:1,4',
            'week' => 'required|integer|between:1,9',
            'title' => 'required'
        ]);

        $suggestion = new Suggestion();
        $suggestion->term = $request->term;
        $suggestion->week = $request->week;
        $suggestion->title = $request->title;
        $suggestion->save();

        return redirect()->route('suggestions.index');
    }

    public function show(Suggestion $suggestion)
    {
        //
    }

    public function edit(Suggestion $suggestion)
    {
        //
    }

    public function update(Request $request, Suggestion $suggestion)
    {
        //
    }

    public function destroy(Suggestion $suggestion)
    {
        //
    }
}
