<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Suggestion;
use App\Meeting;
use App\Topic;
use App\Task;
use App\Listing;
use App\Comment;

class MinuteController extends Controller
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

    public function questions(Meeting $meeting)
    {
        return view('minutes.questions')->with(compact('meeting'));
    }
    
    public function close(Meeting $meeting)
    {
        $meeting->closed_at = $meeting->freshTimestamp();
        $meeting->save();
        return redirect()->route('meetings.minutes.show', $meeting);
    }

    public function show(Meeting $meeting)
    {
        return $meeting;
    }

    public function store_topic(Meeting $meeting, Request $request)
    {
        $request->validate([
            'title' => 'required',
            'duration' => 'nullable|integer',
            'added_by' => 'required|alpha_num'
        ]);

        $order = $meeting->agenda_items->max('listing.order') + 1;

        $topic = new Topic();
        $topic->title = $request->title;
        $meeting->topics()->save($topic, ['added_by' => $request->added_by, 'duration' => $request->duration, 'order' => $order]);

        if($request->go)
        {
            //Retrieve the listing we just saved in a quirky way
            //This works because the topic was just created, and can therefor belong only to one meeting
            $listing = $topic->meetings->first()->listing;

            return redirect()->route('meetings.minutes.listing', [$meeting, $listing->id]);
        }

        return redirect()->back();
    }
}
