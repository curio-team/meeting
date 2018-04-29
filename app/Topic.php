<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{

    public function meetings()
    {
    	return $this->belongsToMany(Meeting::class, 'agenda_items')
    		->as('agenda_item')
    		->withPivot(['added_by', 'duration'])
    		->withTimeStamps();
    }

    public function getClosedAttribute()
    {
    	return !$this->open;
    }
}
