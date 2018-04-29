<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Schoolyear;
use App\Week;
use App\Meeting;

class MeetingController extends Controller
{
    public function create(Schoolyear $schoolyear, Week $week)
    {
    	return view('meetings.create')->with('schoolyear', $schoolyear)->with('week', $week);
    }

    public function store(Schoolyear $schoolyear, Week $week, Request $request)
    {
    	$request->validate([
    		'date' => 'required|date_format:"Y-m-d"',
    		'title' => 'nullable'
    	]);

    	$meeting = new Meeting();
    	$meeting->week_id = $week->id;
    	$meeting->date = $request->date;
    	$meeting->title = $request->title ?? "Teamvergadering";
    	$meeting->save();

    	return redirect()->route('schoolyears.show', $schoolyear);
    }

    public function show(Schoolyear $schoolyear, Week $week, Meeting $meeting)
    {
        return view('meetings.show')
            ->with(compact('schoolyear'))
            ->with(compact('week'))
            ->with(compact('meeting'));
    }
}
