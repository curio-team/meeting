<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Topic;
use App\Comment;

class Task extends Model
{
    
    protected $dates = [
        'resonated_at',
        'secured_at',
        'filed_at',
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

    public function topic()
    {
    	return $this->belongsTo(Topic::class);
    }

    public function getOpenAttribute()
    {
        return ($this->filed_at == null) ? true : false;
    }

    public function getClosedAttribute()
    {
        return !$this->getOpenAttribute();
    }

    public static function generateSlug($length = 3)
    {
        $base = '0123456789abcdefghijklmnopqrstuvwxyz';
        $slug = substr(str_shuffle($base), 0, $length);

        while(self::where('slug', $slug)->count())
        {
            $slug = substr(str_shuffle($base), 0, $length);
        }

        return $slug;
    }
}
