<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Beads extends Model
{
    public $timestamps = false;

    /**
     * get the finishes associated with the beads
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function finishes()
    {
        return $this->belongsToMany('App\Finishes');
    }

    public function userFavorites()
    {
        return $this->hasMany('App\userFavorites');
    }

    public function image(){
        return 'assets/delica11/'.$this->image_file.'.jpg';
    }

}
