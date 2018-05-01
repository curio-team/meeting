<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Topic;
use App\Comment;

class Task extends Model
{
    public function meetings()
    {
    	return $this->morphToMany(Meeting::class, 'agenda_listing')
    		->as('listing')
    		->withPivot(['added_by', 'duration', 'order'])
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
