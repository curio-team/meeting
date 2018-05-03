<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Topic;
use App\Task;

class SearchController extends Controller
{
    public function show()
    {
    	return view('search.show');
    }

    public function titles(Request $request)
    {
    	$request->validate(['q' => 'required']);

    	$topics = Topic::where('title', 'LIKE', "%{$request->q}%")->get();
    	$tasks = Task::where('title', 'LIKE', "%{$request->q}%")->get();

    	$merged = $topics->merge($tasks);

    	return view('search.show')->with('results', $merged);
    }

    public function slug(Request $request)
    {
    	$request->validate(['q' => 'required|alpha_num']);
    	$task = Task::where('slug', $request->q)->first();
    	
    	if($task != null) return redirect()->route('tasks.show', $task);
    	return redirect()->back()->with('status', ['warning' => 'Taak niet gevonden...']);
    }
}
