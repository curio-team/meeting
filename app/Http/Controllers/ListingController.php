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

    public function destroy(Meeting $meeting, Request $request)
    {
    	$listing = Listing::find($request->listing);
    	$parent = $listing->parent;

        $parent->meetings()->detach($meeting);

    	if($parent instanceof \App\Topic && $parent->meetings->count() == 0)
        {
            $parent->delete();
            return redirect()->back()->with('status', [
                'success' => 'Agendapunt verwijderd!',
                'danger' => 'Dit onderwerp was niet verbonden aan een andere meeting en is daarom in zijn geheel verwijderd.'
            ]);
        }

    	return redirect()->back()->with('status', [
                'success' => 'Agendapunt verwijderd!',
                'info' => 'De taak / het onderwerp is enkel van deze agenda verwijderd, maar bestaat nog wel in het systeem.'
            ]);
    }
}
