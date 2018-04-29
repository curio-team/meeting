<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    public function meetings()
    {
    	return $this->morphToMany(Meeting::class, 'agendable')
    		->as('agenda_item')
    		->withPivot(['added_by', 'duration', 'order'])
    		->withTimeStamps();
    }
}
