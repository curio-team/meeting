<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Suggestion;
use App\Schoolyear;
use App\Week;
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

    public function add(Meeting $meeting, Request $request)
    {
    	$request->validate([
    		'title' => 'required',
    		'duration' => 'required|integer',
            'added_by' => 'required|alpha_num'
    	]);

    	$topic = new Topic();
    	$topic->title = $request->title;
    	$topic->open = true;
    	$meeting->topics()->save($topic, ['added_by' => $request->added_by, 'duration' => $request->duration]);

    	return redirect()->back();
    }

    public function add_go(Meeting $meeting, Request $request)
    {
        $request->validate([
            'title' => 'required',
            'added_by' => 'required|alpha_num'
        ]);

        $order = $meeting->agenda_items->max('listing.order') + 1;

        $topic = new Topic();
        $topic->title = $request->title;
        $topic->open = true;
        $meeting->topics()->save($topic, ['added_by' => $request->added_by, 'order' => $order]);
        
        //Retrieve the listing we just saved in a quirky way
        //This works because the topic was just created, and can therefor belong only to one meeting
        $listing = $topic->meetings->first()->listing;

        return redirect()->route('meeting.minute.item', [$meeting, $listing->id]);
    }

    public function save(Meeting $meeting, Request $request)
    {
        foreach($request->items as $id => $item)
        {
            $listing = Listing::find($id);
            $listing->order = $item['order'];
            $listing->duration = $item['duration'];
            $listing->save();
        }

        $meeting->load(['topics', 'tasks']);

        //make sure _every_ item has an order set
        $max = $meeting->agenda_items->max('listing.order');
        foreach($meeting->agenda_items as $item)
        {
            if($item->listing->order == null)
            {
                $max++;
                $item->listing->order = $max;
                $item->listing->save();
            }
        }

        $meeting->load(['topics', 'tasks']);
        $next = $meeting->agenda_items->first();

        return redirect()->route('meeting.minute.item', [$meeting, $next->listing->id]);
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
    		->with($type, $listing->parent)
    		->with('next', $next)
    		->with('meeting', $meeting)
    		->with('meetings', Meeting::where('date', '>', date('Y-m-d'))->orderBy('date')->get());
    }

    public function comment(Meeting $meeting, $commentable_type, $commentable_id, Request $request)
    {
    	$request->validate(['comment' => 'required']);
    	$comment = new Comment();
    	$comment->author = 'br10';
    	$comment->text = $request->comment;

        $commentable_type = 'App\\' . ucfirst($commentable_type);
        $commentable = $commentable_type::find($commentable_id);

    	$commentable->comments()->save($comment);
    	return redirect()->back();
    }

    public function task(Meeting $meeting, Topic $topic, Request $request)
    {
    	$request->validate([
    		'title' => 'required',
    		'owner' => 'alpha_num|size:4',
    		'agendate' => 'integer|nullable'
    	]);

    	$task = new Task();
    	$task-> slug = Task::generateSlug();
    	$task->owner = $request->owner;
    	$task->title = $request->title;
    	$topic->tasks()->save($task);

    	if($request->agendate != null && $request->agendate != 0)
    	{
    		$meeting = Meeting::find($request->agendate);
    		$meeting->tasks()->attach($task, ['added_by' => $request->owner]);
    	}

    	return redirect()->back();
    }

    public function end(Meeting $meeting)
    {
        return view('minutes.end')->with(compact('meeting'));
    }
}
