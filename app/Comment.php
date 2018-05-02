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
}
