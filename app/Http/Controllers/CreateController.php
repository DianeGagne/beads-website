<?php
/**
 * Created by PhpStorm.
 * User: Diane
 * Date: 7/3/2017
 * Time: 11:02 PM
 */

namespace App\Http\Controllers;

use App\Patterns;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Input;


class CreateController extends BaseController
{

    /**
     * Take an uploaded file, bead type, size & max colors
     * and create a matrix output of the image in bead form
     */
    public function createFromImage()
    {
    }

}