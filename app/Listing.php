<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\MorphPivot;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\Pivot;


class Listing extends MorphPivot
{
    protected $table = 'agenda_listings';

    public function parent()
    {
        return $this->morphTo('agenda_listing');
    }

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
