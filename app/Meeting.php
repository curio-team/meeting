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

	public function agendables()
	{
		return collect ($this->getRelations())
			->collapse()
			->sortBy(function ($agendable, $key) {
			    return $agendable->agenda_item->order ?? '999999';
			});;
	}

	public function topics()
    {
    	return $this->morphedByMany(Topic::class, 'agendable')
    		->as('agenda_item')
    		->withPivot(['id', 'added_by', 'duration', 'order'])
    		->withTimeStamps();
    }

    public function tasks()
    {
    	return $this->morphedByMany(Task::class, 'agendable')
    		->as('agenda_item')
    		->withPivot(['id', 'added_by', 'duration', 'order'])
    		->withTimeStamps();
    }

    public function __get($key)
    {
        if($key == 'agendables') return $this->agendables();
        return parent::__get($key);
    }

}
