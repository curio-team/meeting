<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Suggestion extends Model
{
    public static function findForMeeting(Meeting $meeting)
    {
    	$week = $meeting->week;
    	if($week->term == null) return false;
    	return self::where('term', $week->term)->where('week', $week->week)->get();
    }
}
