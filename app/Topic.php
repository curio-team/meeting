<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{

    public function meetings()
    {
    	return $this->morphToMany(Meeting::class, 'agendable')
    		->as('agenda_item')
    		->withPivot(['added_by', 'duration', 'order'])
    		->withTimeStamps();
    }

    public function getClosedAttribute()
    {
    	return !$this->open;
    }
}
