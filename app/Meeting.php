<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DateTime;
use App\Week;
use App\Topic;
use App\Task;

class Meeting extends Model
{

	protected $dates = ['date', 'created_at', 'updated_at'];
	protected $with = ['topics', 'tasks'];

    public function week()
    {
        return $this->belongsTo(Week::class);
    }

	public function agenda_items()
	{
		return collect ($this->getRelations())
			->collapse()
			->sortBy(function ($agenda_item, $key) {
			    return $agenda_item->listing->order ?? '999999';
			})
            ->values();
	}

	public function topics()
    {
    	return $this->morphedByMany(Topic::class, 'agenda_listing')
    		->as('listing')
    		->withPivot(['id', 'added_by', 'duration', 'order'])
    		->withTimeStamps();
    }

    public function tasks()
    {
    	return $this->morphedByMany(Task::class, 'agenda_listing')
    		->as('listing')
    		->withPivot(['id', 'added_by', 'duration', 'order'])
    		->withTimeStamps();
    }

    public function __get($key)
    {
        if($key == 'agenda_items') return $this->agenda_items();
        return parent::__get($key);
    }

}
