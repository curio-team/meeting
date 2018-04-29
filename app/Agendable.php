<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\MorphPivot;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\Pivot;


class Agendable extends MorphPivot
{
    protected $table = 'agendables';

    public function getCreatedAtColumn()
    {
        return 'created_at';
    }

    public function getUpdatedAtColumn()
    {
        return 'updated_at';
    }

    //override this function to use it's "grandparents" constructor because of weird error
    protected function setKeysForSaveQuery(Builder $query)
    {
        return Pivot::setKeysForSaveQuery($query);
    }
}
