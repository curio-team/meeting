<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Comment extends Model
{
    public function commentable()
    {
    	return $this->morphTo();
    }

    public function canEdit()
    {
    	if($this->author == \Auth::user()->id && $this->created_at > \Carbon\Carbon::now()->subMinutes(30))
    	{
    		return true;
    	}

    	return false;
    }
}
