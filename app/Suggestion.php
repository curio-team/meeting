<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Schoolyear;

class Suggestion extends Model
{
    
    public function schoolyears()
    {
    	return $this->belongsToMany(Schoolyear::class, 'suggestions_considered');
    }

    public static function findForMeeting(Meeting $meeting)
    {
    	$week = $meeting->week;
    	if($week->term == null) return collect();

        if($week->term == "Sep")
        {
            return self
            ::whereRaw('(term = ? AND week <= ?)', [$week->term, $week->week])
            ->whereDoesntHave('schoolyears', function($query) use($meeting){
                $query->where('schoolyear_id', $meeting->week->schoolyear->id);
            })->get();
        }
        if($week->term == "Feb")
        {
            return self
            ::whereRaw('term = "Sep" OR (term = ? AND week <= ?)', [$week->term, $week->week])
            ->whereDoesntHave('schoolyears', function($query) use($meeting){
                $query->where('schoolyear_id', $meeting->week->schoolyear->id);
            })->get();
        }

    	
    }
}
