<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{
    public function week()
    {
    	return $this->belongsTo(\App\Week::class);
    }
}
