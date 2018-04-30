<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Suggestion;
use App\Schoolyear;
use App\Week;
use App\Meeting;
use App\Agenda_item;

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
            ->with('suggestions', Suggestion::findForMeeting($meeting))
            ->with(compact('schoolyear'))
            ->with(compact('week'))
            ->with(compact('meeting'));
    }

    public function order(Schoolyear $schoolyear, Week $week, Meeting $meeting)
    {
        return view('meetings.order')
            ->with(compact('schoolyear'))
            ->with(compact('week'))
            ->with(compact('meeting'));
    }

    public function sort(Schoolyear $schoolyear, Week $week, Meeting $meeting, Request $request)
    {
        foreach($request->order as $id => $order)
        {
            $agenda_item = Agenda_item::find($id);
            $agenda_item->order = $order;
            $agenda_item->save();
        }

        return redirect()->route('schoolyears.weeks.meetings.show', [$schoolyear, $week, $meeting]);
    }
}
