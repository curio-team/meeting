<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Meeting;
use App\Topic;
use App\Task;
use App\Listing;
use App\Comment;

class MinuteControllerBackground extends Controller
{

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

            return redirect()->route('meetings.minute.listing', [$meeting, $listing->id]);
        }

    	return redirect()->back();
    }
    
}
