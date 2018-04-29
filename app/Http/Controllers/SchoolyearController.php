<?php

namespace App\Http\Controllers;

use App\Schoolyear;
use Illuminate\Http\Request;
use DateTime;

class SchoolyearController extends Controller
{
    
    public function index()
    {
        return view('schoolyears.index')->with('schoolyears', Schoolyear::all());
    }

    public function show(Schoolyear $schoolyear)
    {
        $schoolyear->load('weeks.meetings');
        return view('schoolyears.show')->with('schoolyear', $schoolyear);
    }

    public function create()
    {
        return view("schoolyears.create");
    }

    public function store(Request $request)
    {
        $request->validate([
            'start' => 'required|date_format:"Y-m-d"',
            'end' => 'required|date_format:"Y-m-d"'
        ]);

        $check = Schoolyear::whereYear('start', date('Y', strtotime($request->start)))->first();
        if($check != null)
        {
            return redirect()->back()->withErrors("Beginjaar mag niet gelijk zijn aan een ander schooljaar ({$check->title} in dit geval)");
        }

        //make sure start/end are respectively monday/friday
        $start = new DateTime($request->start);
        $start->modify('monday this week');
        $end = new DateTime($request->end);
        $end->modify('friday this week');

        $schoolyear = new Schoolyear();
        $schoolyear->start = $start->format('Y-m-d');
        $schoolyear->end = $end->format('Y-m-d');
        $schoolyear->save();

        return redirect()->route('schoolyears.weeks.show', $schoolyear);
    }
    
}
