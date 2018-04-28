<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Schoolyear;
use App\Week;
use App\Meeting;
use DateTime;

class WeekController extends Controller
{
    public function show(Schoolyear $schoolyear)
    {

    	$date = new DateTime($schoolyear->start);
        $end_of_year = new DateTime($schoolyear->end);

        $weeks = array();
        while($date < $end_of_year)
        {
            $start = clone $date;
            $end = clone $date;
            $end->modify('friday this week');

            $week = Week::firstOrNew(
                ['schoolyear_id' => $schoolyear->id, 'iso_week' => $start->format('W')],
                ['id' => 0, 'year' => $start->format('Y'), 'term' => null, 'week' => null, 'description' => null]
            );

            $weeks[] = $week;
            $date->modify('+1 week');
        }

        return view('weeks.show')
            ->with('weeks', $weeks)
            ->with('schoolyear', $schoolyear);

    }

    public function store(Request $request, Schoolyear $schoolyear)
    {

        $request->validate([
            'weeks.*.term' => 'nullable|digits:1',
            'weeks.*.week' => 'nullable|digits:1'
        ]);

    	foreach($request->weeks as $req_week)
    	{
    		$week = Week::firstOrNew(
                ['schoolyear_id' => $schoolyear->id, 'iso_week' => $req_week['iso_week']]
            );

    		$week->year = $req_week['year'];
            $week->term = $req_week['term'];
            $week->week = $req_week['week'];
            $week->description = $req_week['description'];
            $week->save();

            if($req_week['meeting'] ?? false)
            {
                $meeting = new Meeting();
                $meeting->week_id = $week->id;
                $meeting->date = $week->start->modify("+{$request->day} days")->format('Y-m-d');
                $meeting->title = 'Teamvergadering';
                $meeting->save();
            }
    	}

    	return redirect()->route('schoolyears.show', $schoolyear);	
    }
}
