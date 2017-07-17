<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Finishes extends Model
{

    public $timestamps = false;
    
    /**
     * get the beads associated with the given finish
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function beads()
    {
        return $this->belongsToMany('App\Beads');
    }
}
