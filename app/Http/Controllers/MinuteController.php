<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Suggestion;
use App\Schoolyear;
use App\Week;
use App\Meeting;
use App\Topic;
use App\Task;
use App\Agenda_item;
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
    		'duration' => 'required|integer'
    	]);

    	$topic = new Topic();
    	$topic->title = $request->title;
    	$topic->open = true;
    	$meeting->topics()->save($topic, ['added_by' => 11, 'duration' => $request->duration]);

    	return redirect()->back();
    }

    public function save(Meeting $meeting, Request $request)
    {
        foreach($request->items as $id => $item)
        {
            $agenda_item = Agenda_item::find($id);
            $agenda_item->order = $item['order'];
            $agenda_item->duration = $item['duration'];
            $agenda_item->save();
        }

        $meeting->load(['topics', 'tasks']);
        $next = $meeting->agenda_items->first();

        return redirect()->route('meeting.minute.item', [$meeting, $next->listing->id]);
    }

    public function item(Meeting $meeting, Agenda_item $agenda_item)
    {
    	$type = strtolower(class_basename(get_class($agenda_item->parent)));
    	return view("minutes.$type")
    		->with($type, $agenda_item->parent)
    		->with('meeting', $meeting)
    		->with('meetings', Meeting::where('date', '>', date('Y-m-d'))->orderBy('date')->get());
    }

    public function comment(Meeting $meeting, Topic $topic, Request $request)
    {
    	$request->validate(['comment' => 'required']);
    	$comment = new Comment();
    	$comment->author = 'br10';
    	$comment->text = $request->comment;

    	$topic->comments()->save($comment);
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
}
