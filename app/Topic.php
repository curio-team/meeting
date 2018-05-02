<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Task;
use App\Comment;

class Topic extends Model
{

    protected $dates = [
        'closed_at',
        'created_at',
        'updated_at'
    ];

    public function meetings()
    {
    	return $this->morphToMany(Meeting::class, 'agenda_listing')
    		->as('listing')
    		->withPivot(['id', 'added_by', 'duration', 'order'])
    		->withTimeStamps();
    }

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    public function tasks()
    {
    	return $this->hasMany(Task::class);
    }

    public function getOpenAttribute()
    {
        return ($this->closed_at == null) ? true : false;
    }

    public function getClosedAttribute()
    {
    	return !$this->getOpenAttribute();
    }
}
