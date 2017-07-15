<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property int $id
 */
class Patterns extends Model
{
    protected $fillable = [
        'width',
        'height',
        'bead_type',
        'jsonPattern'];
}
