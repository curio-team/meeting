<?php

namespace App\Http\Controllers;

use App\Schoolyear;
use Illuminate\Http\Request;
use DateTime;

class SchoolyearController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('schoolyears.index')->with('schoolyears', Schoolyear::all());
    }

    public function show(Schoolyear $schoolyear)
    {
        return view('schoolyears.show')->with('schoolyear', $schoolyear);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("schoolyears.create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
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
    

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Schoolyear  $schoolyear
     * @return \Illuminate\Http\Response
     */
    public function edit(Schoolyear $schoolyear)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Schoolyear  $schoolyear
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Schoolyear $schoolyear)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Schoolyear  $schoolyear
     * @return \Illuminate\Http\Response
     */
    public function destroy(Schoolyear $schoolyear)
    {
        //
    }
}
