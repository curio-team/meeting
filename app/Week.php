<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DateTime;

class Week extends Model
{
    protected $guarded = [];

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
    	if($this->week == null) return $this->description;
    	return $this->term . '.' . $this->week;
    }
}
