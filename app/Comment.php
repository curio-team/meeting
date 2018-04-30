<?php

namespace App;
use App\Topic;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    public function topic()
    {
    	return $this->belongsTo(Topic::class);
    }
}
