<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Suggestion;
use App\Schoolyear;
use App\Week;
use App\Meeting;
use App\Listing;

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
        if($meeting->closed) return $this->show_minutes($schoolyear, $week, $meeting);
        return view('meetings.show')
            ->with('suggestions', Suggestion::findForMeeting($meeting))
            ->with('meetings', Meeting::where('date', '>', date('Y-m-d'))->orderBy('date')->get())
            ->with(compact('schoolyear'))
            ->with(compact('week'))
            ->with(compact('meeting'));
    }

    public function show_minutes(Schoolyear $schoolyear, Week $week, Meeting $meeting)
    {
        $my_items = collect();
        foreach($meeting->agenda_items as $item)
        {
            $events = collect();

            foreach($item->comments as $comment)
            {
                $events->push([
                    'type' => 'comment',
                    'text' => $comment->text,
                    'date' => $comment->created_at,
                    'user' => $comment->author
                ]);
            }
            
            if($item instanceof \App\Topic && $item->closed)
            {
                $events->push([
                    'type' => 'state',
                    'text' => "<em>Onderwerp gesloten</em>",
                    'date' => $item->closed_at,
                    'user' => null
                ]);
            }

            if($item instanceof \App\Topic && $item->tasks->count())
            {
                foreach($item->tasks as $task)
                {
                    $events->push([
                        'type' => 'task',
                        'text' => "<em>Taak toegevoegd:</em><br />{$task->slug} | {$task->owner} | {$task->title}",
                        'date' => null,
                        'user' => null
                    ]);
                }
            }

            if($item instanceof \App\Task)
            {
                if($item->resonated_at)
                {
                    $events->push([
                        'type' => 'state',
                        'text' => "<em>Actie geresoneerd</em>",
                        'date' => $item->resonated_at,
                        'user' => null
                    ]);
                }
                if($item->secured_at)
                {
                    $events->push([
                        'type' => 'state',
                        'text' => "<em>Actie geborgd</em>",
                        'date' => $item->secured_at,
                        'user' => null
                    ]);
                }
                if($item->filed_at)
                {
                    $events->push([
                        'type' => 'state',
                        'text' => "<em>Actie afgerond</em>",
                        'date' => $item->filed_at,
                        'user' => null
                    ]);
                }
            }

            $meetings_after = $item->meetings()->where('date', '>', $meeting->date)->get();
            if($meetings_after->count())
            {
                foreach($meetings_after as $after)
                {
                    $events->push([
                        'type' => 'meeting',
                        'text' => "<em>Toegevoegd aan vergadering:</em><br />{$after->title}, {$after->date}",
                        'date' => null,
                        'user' => null
                    ]);
                }
            }

            $events->sortBy('date');

            $my_items->put($item->listing->id, $events);
        }

        //return $my_items;

        return view('minutes.show')
                ->with(compact('schoolyear'))
                ->with(compact('week'))
                ->with(compact('meeting'))
                ->with(compact('my_items'));
    }

    public function agenda_edit(Meeting $meeting)
    {
        return view('meetings.agenda_edit')
            ->with('schoolyear', $meeting->week->schoolyear)
            ->with('week', $meeting->week)
            ->with('meeting', $meeting);
    }

    public function agenda_update(Meeting $meeting, Request $request)
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

        if($request->start_minutes)
        {
            $meeting->load(['topics', 'tasks']);
            $next = $meeting->agenda_items->first();
            return redirect()->route('meetings.minutes.listing', [$meeting, $next->listing->id]);
        }

        return redirect()->route('schoolyears.weeks.meetings.show', [$meeting->week->schoolyear, $meeting->week, $meeting]);
    }
}
