<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int height
 * @property int width
 * @property string svg_image
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property int $id
 */
class Patterns extends Model
{
    protected $fillable = [
        'width',
        'height',
        'bead_type',
        'svg_image',];
}
