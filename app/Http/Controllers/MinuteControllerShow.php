<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Suggestion;
use App\Meeting;
use App\Listing;

class MinuteControllerShow extends Controller
{
    
    public function start(Meeting $meeting)
    {
    	return view('minutes.start')
    		->with('suggestions', Suggestion::findForMeeting($meeting))
    		->with('meetings', Meeting::where('date', '>', date('Y-m-d'))->orderBy('date')->get())
            ->with('schoolyear', $meeting->week->schoolyear)
            ->with('week', $meeting->week)
            ->with('meeting', $meeting);
    }

    public function item(Meeting $meeting, Listing $listing)
    {
        //Find the place of this particular agenda-item in the meeting's agenda
        $my_place = $meeting->agenda_items->search(function ($item, $key) use ($listing){
            return $item->listing->id == $listing->id;
        });

        $next_place = $my_place + 1;
        $count = $meeting->agenda_items->count();
        $next = ($next_place < $count) ? $meeting->agenda_items[$next_place] : null;

        $type = strtolower(class_basename(get_class($listing->parent)));
        return view("minutes.$type")
            ->with('listing', $listing)
            ->with($type, $listing->parent)
            ->with('next', $next)
            ->with('meeting', $meeting)
            ->with('meetings', Meeting::where('date', '>', date('Y-m-d'))->orderBy('date')->get());
    }

    public function end(Meeting $meeting)
    {
        return view('minutes.end')->with(compact('meeting'));
    }
    
}
