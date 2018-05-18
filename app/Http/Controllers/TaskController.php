<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Meeting;
use App\Topic;
use App\Task;

class TaskController extends Controller
{
    public function show(Task $task)
    {
        return view('tasks.show')->with(compact('task'));
    }

    public function change_state(Task $task, Request $request)
    {
    	$request->validate(['field' => 'required']);
    	$now = $task->freshTimestamp();
    	$field = $request->field;

    	$task->$field = $now;
    	if($field == 'secured_at' && $task->resonated_at == null)
    	{
    		$task->resonated_at = $now;
    	}

    	if($field == 'filed_at' && $task->resonated_at == null)
    	{
    		$task->resonated_at = $now;
    	}

    	if($field == 'filed_at' && $task->secured_at == null)
    	{
    		$task->secured_at = $now;
    	}

    	$task->save();
    	return redirect()->back();
    }

    public function store_with_topic(Topic $topic, Request $request)
    {
        $request->validate([
            'title' => 'required|max:191',
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

    public function attach(Meeting $meeting, Request $request)
    {
        $request->validate([
            'task' => 'required|integer',
            'duration' => 'required|integer'
        ]);

        $meeting->tasks()->attach($request->task, ['added_by' => Auth::id(), 'duration' => $request->duration]);

        return redirect()->route('schoolyears.weeks.meetings.show', [$meeting->week->schoolyear, $meeting->week, $meeting]);
    }
    
}
