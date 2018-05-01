<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Task;

class TaskController extends Controller
{
    public function change_state(Task $task, Request $request)
    {
    	$request->validate(['field' => 'required']);
    	$now = $task->freshTimestamp();
    	$field = $request->field;

    	$task->$field = $now;
    	if($field == 'secured_at' && $task->resonated_at == null)
    	{
    		$task->resonated_at = $now;
    	}

    	if($field == 'filed_at' && $task->resonated_at == null)
    	{
    		$task->resonated_at = $now;
    	}

    	if($field == 'filed_at' && $task->secured_at == null)
    	{
    		$task->secured_at = $now;
    	}

    	$task->save();
    	return redirect()->back();
    }
}
