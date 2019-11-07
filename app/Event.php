<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $dates = [
        'date',
        'created_at',
        'updated_at'
    ];
}
