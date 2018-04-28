<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DateTime;

class Meeting extends Model
{

	protected $dates = ['date', 'created_at', 'updated_at'];

}
