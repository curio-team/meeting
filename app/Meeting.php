<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DateTime;

class Meeting extends Model
{

    protected $appends = ['date'];

    public function schoolyear()
    {
    	return $this->belongsTo(\App\Schoolyear::class);
    }

    public function topics()
    {
    	return $this->hasMany(\App\Topic::class);
    }

    public function tasks()
    {
    	return $this->hasMany(\App\Task::class);
    }

    protected function getDateAttribute()
    {
        $date = new DateTime();
        $date->setISODate($this->year, $this->iso_week, $this->iso_day);
        return $date;
    }
}
