<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Schoolyear extends Model
{
    public static function current()
    {
    	$year = Schoolyear::whereDate('start', '<', Carbon::now())->whereDate('end', '>', Carbon::now());
    	return $year->first();
    }

    public function weeks()
    {
    	return $this->hasMany(\App\Week::class);
    }

    public function getRouteKey()
    {
    	return $this->getSlugAttribute();
    }

    public function getSlugAttribute()
    {
    	return date('y', strtotime($this->start)).date('y', strtotime($this->end));
    }

    public function getTitleAttribute()
    {
        return date('Y', strtotime($this->start)) . ' - ' . date('Y', strtotime($this->end));
    }
}
