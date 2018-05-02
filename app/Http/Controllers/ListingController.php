<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Meeting;
use App\Listing;

class ListingController extends Controller
{
    public function attach(Listing $listing, Request $request)
    {
    	$request->validate(['meeting' => 'required|integer|min:1']);
    	$listing->parent->meetings()->attach($request->meeting, ['added_by' => Auth::id()]);
    	return redirect()->back()->with('status', ['success' => 'Toegevoegd!']);
    }
}
