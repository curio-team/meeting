<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Topic;

class Task extends Model
{
    public function meetings()
    {
    	return $this->morphToMany(Meeting::class, 'agenda_item')
    		->as('listing')
    		->withPivot(['added_by', 'duration', 'order'])
    		->withTimeStamps();
    }

    public function topic()
    {
    	return $this->belongsTo(Topic::class);
    }
}
