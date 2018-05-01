<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Task;
use App\Comment;

class Topic extends Model
{

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

    public function getClosedAttribute()
    {
    	return !$this->open;
    }
}
