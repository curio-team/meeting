<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DateTime;
use App\Meeting;

class Week extends Model
{
    protected $guarded = [];

    public function meetings()
    {
        return $this->hasMany(\App\Meeting::class);
    }

    public function getStartAttribute()
    {
    	$date = new DateTime();
    	$date->setISODate($this->year, $this->iso_week, 1);
    	return $date;
    }

    public function getEndAttribute()
    {
    	$date = new DateTime();
    	$date->setISODate($this->year, $this->iso_week, 5);
    	return $date;
    }

    public function getTitleAttribute()
    {
        return $this->getNumberAttribute() ?? $this->description ?? null;
    }

    public function getNumberAttribute()
    {
        if($this->week == null) return null;
        return $this->term . '.' . $this->week;
    }
}
