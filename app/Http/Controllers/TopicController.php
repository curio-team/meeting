<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Schoolyear;
use App\Week;
use App\Meeting;
use App\Topic;

class TopicController extends Controller
{

    public function create(Schoolyear $schoolyear, Week $week, Meeting $meeting)
    {
    	return view('topics.create')
            ->with(compact('schoolyear'))
            ->with(compact('week'))
            ->with(compact('meeting'));
    }

    public function store(Schoolyear $schoolyear, Week $week, Meeting $meeting, Request $request)
    {
    	$request->validate([
    		'title' => 'required',
    		'duration' => 'required|integer'
    	]);

    	$topic = new Topic();
    	$topic->title = $request->title;
    	$meeting->topics()->save($topic, ['added_by' => Auth::id(), 'duration' => $request->duration]);

    	return redirect()->route('schoolyears.weeks.meetings.show', [$schoolyear, $week, $meeting]);
    }

    public function attach(Meeting $meeting, Request $request)
    {
    	$request->validate([
    		'topic' => 'required|integer',
    		'duration' => 'required|integer'
    	]);

    	$meeting->topics()->attach($request->topic, ['added_by' => Auth::id(), 'duration' => $request->duration]);

    	return redirect()->route('schoolyears.weeks.meetings.show', [$meeting->week->schoolyear, $meeting->week, $meeting]);
    }
    
    public function close(Topic $topic, Request $request)
    {
        $topic->closed_at = $topic->freshTimestamp();
        $topic->save();
        return redirect()->back();
    }
}
