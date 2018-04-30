<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Schoolyear;
use App\Week;
use App\Meeting;
use App\Topic;
use App\Task;
use App\Agenda_item;
use App\Comment;

class MinuteController extends Controller
{
    public function show(Agenda_item $agenda_item)
    {
    	$type = strtolower(class_basename(get_class($agenda_item->parent)));
    	return view("minutes.$type")
    		->with($type, $agenda_item->parent)
    		->with('meetings', Meeting::where('date', '>', date('Y-m-d'))->orderBy('date')->get());
    }

    public function comment(Topic $topic, Request $request)
    {
    	$request->validate(['comment' => 'required']);
    	$comment = new Comment();
    	$comment->author = 'br10';
    	$comment->text = $request->comment;

    	$topic->comments()->save($comment);
    	return redirect()->back();
    }

    public function task(Topic $topic, Request $request)
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
