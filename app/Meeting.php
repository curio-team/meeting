<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DateTime;
use App\Topic;

class Meeting extends Model
{

	protected $dates = ['date', 'created_at', 'updated_at'];

	public function topics()
    {
    	return $this->belongsToMany(Topic::class, 'agenda_items')
    		->as('agenda_item')
    		->withPivot(['added_by', 'duration'])
    		->withTimeStamps();
    }

}
