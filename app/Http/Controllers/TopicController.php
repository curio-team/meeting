<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Schoolyear;
use App\Week;
use App\Meeting;
use App\Topic;
use App\Comment;

class TopicController extends Controller
{

    public function show(Topic $topic)
    {
        return view('topics.show')->with(compact('topic'));
    }

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
    		'title' => 'required|max:191',
    		'duration' => 'required|integer',
            'comment' => 'nullable'
    	]);

    	$topic = new Topic();
    	$topic->title = $request->title;
    	$topic = $meeting->topics()->save($topic, ['added_by' => Auth::id(), 'duration' => $request->duration]);

        if($request->comment != null)
        {
            $comment = new Comment();
            $comment->author = Auth::id();
            $comment->text = $request->comment;
            $topic->comments()->save($comment);

            $listing = $topic->meetings()->first()->listing;
            $listing->order = 0;
            $listing->save();
        }

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
    
    public function close(Topic $topic)
    {
        $topic->closed_at = $topic->freshTimestamp();
        $topic->save();
        return redirect()->back();
    }

    public function reopen(Topic $topic)
    {
        $topic->closed_at = null;
        $topic->save();
        return redirect()->back();
    }
}
