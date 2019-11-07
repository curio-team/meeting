<?php

namespace App\Http\Controllers;

use App\Event;
use App\Schoolyear;
use App\Week;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function create(Schoolyear $schoolyear, Week $week)
    {
        return view('events.create')
            ->with('schoolyear', $schoolyear)
            ->with('week', $week);
    }

    public function store(Schoolyear $schoolyear, Week $week, Request $request)
    {
        $request->validate([
            'date' => 'required|date_format:"Y-m-d"',
            'title' => 'required|max:191'
        ]);

        $event = new Event();
        $event->week_id = $week->id;
        $event->date = $request->date;
        $event->title = $request->title;
        $event->save();

        return redirect()->route('schoolyears.show', $schoolyear);
    }

    public function edit(Schoolyear $schoolyear, Week $week, Event $event)
    {
        return view('events.edit')
            ->with('schoolyear', $schoolyear)
            ->with('week', $week)
            ->with('event', $event);
    }

    public function update(Schoolyear $schoolyear, Week $week, Event $event, Request $request)
    {
        $request->validate([
            'date' => 'required|date_format:"Y-m-d"',
            'title' => 'required|max:191'
        ]);

        $event->date = $request->date;
        $event->title = $request->title;
        $event->save();

        return redirect()->route('schoolyears.show', $schoolyear);
    }

    public function destroy(Schoolyear $schoolyear, Week $week, Event $event)
    {
        $event->delete();
        return redirect()->route('schoolyears.show', $schoolyear);
    }
}
