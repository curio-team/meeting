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
            // if($week->term)
            // {
                $events[] = array(
                    "id" => $week->id,
                    "title" => "{$week->title}",
                    "allDay" => true,
                    "start" => $week->start->format('Y-m-d'),
                    "end" => $week->end->modify('+1 day')->format('Y-m-d'),
                    "rendering" => "background",
                    "className" => $week->term ? "weeknumber primary" : "weeknumber secondary"
                );
            #}

            // if($meeting->term != null)
            // {
            //     $date = new DateTime();
            //     $start = $date->setISODate($meeting->year, $meeting->iso_week, 1)->format('Y-m-d');
            //     $end = $date->setISODate($meeting->year, $meeting->iso_week, 7)->format('Y-m-d');

            //     $events[] = array(
            //         "id" => "weeks",
            //         "title" => $week->title,
            //         "allDay" => true,
            //         "start" => $start,
            //         "end" => $end,
            //         "rendering" => "background"
            //     );
            // }
        }

        return $events;
    }

   	// public function json(Request $request)
   	// {
   	// 	$start = new DateTime($request->start);
   	// 	$end = new DateTime($request->end);

   	// 	$meetings = DB::select(
   	// 		"SELECT * FROM (SELECT *, STR_TO_DATE(CONCAT(`year`, LPAD(iso_week, 2, 0), iso_day), '%x%v%w') AS date FROM meetings) AS a WHERE (date BETWEEN :start AND :end)",
   	// 		["start" => $request->start, "end" => $request->end]
   	// 	);

   	// 	$events = array();
   	// 	foreach ($meetings as $meeting)
   	// 	{
   	// 		$events[] = array(
   	// 			"id" => $meeting->id,
   	// 			"title" => "Teamoverleg",
   	// 			"allDay" => true,
   	// 			"start" => $meeting->date,
   	// 			"end" => $meeting->date
   	// 		);

   	// 		if($meeting->term != null)
   	// 		{
   	// 			$date = new DateTime();
   	// 			$start = $date->setISODate($meeting->year, $meeting->iso_week, 1)->format('Y-m-d');
   	// 			$end = $date->setISODate($meeting->year, $meeting->iso_week, 7)->format('Y-m-d');

   	// 			$events[] = array(
	   // 				"id" => "weeks",
	   // 				"title" => "wk{$meeting->term}.{$meeting->week}",
	   // 				"allDay" => true,
	   // 				"start" => $start,
	   // 				"end" => $end,
	   // 				"rendering" => "background"
	   // 			);
   	// 		}
   	// 	}

   	// 	return $events;
   	// }
}
