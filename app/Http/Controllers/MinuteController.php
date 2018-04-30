<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Schoolyear;
use App\Week;
use App\Meeting;
use App\Topic;
use App\Task;
use App\Agenda_item;

class MinuteController extends Controller
{
    public function show(Agenda_item $agenda_item)
    {
    	$type = strtolower(class_basename(get_class($agenda_item->parent)));
    	return view("minutes.$type")->with($type, $agenda_item->parent);
    }
}
