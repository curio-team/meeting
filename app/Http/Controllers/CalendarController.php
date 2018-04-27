<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DateTime;
use App\Week;
use DB;

class CalendarController extends Controller
{
    public function show()
    {
    	return view('calendar.show');
    }

    public function json(Request $request)
    {
        $start = new DateTime($request->start);
        $end = new DateTime($request->end);

        $result = DB::select(
            "SELECT * FROM (SELECT *, STR_TO_DATE(CONCAT(`year`, LPAD(iso_week, 2, 0), 1), '%x%v%w') AS date FROM weeks) AS a WHERE (date BETWEEN :start AND :end)",
            ["start" => $request->start, "end" => $request->end]
        );
        $weeks = Week::hydrate($result);

        $events = array();
        foreach ($weeks as $week)
        {
            $events[] = array(
                "id" => $week->id,
                "title" => "{$week->title}",
                "allDay" => true,
                "start" => $week->start->format('Y-m-d'),
                "end" => $week->end->modify('+1 day')->format('Y-m-d'),
                "rendering" => "background",
                "className" => $week->term ? "weeknumber primary" : "weeknumber secondary"
            );
        }

        return $events;
    }
}
