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


class PatternsController extends BaseController
{
    public function savePattern(){
        $patternInfo = Input::all();

        $pattern = new Patterns();
        $pattern->width = $patternInfo['width'];
        $pattern->height = $patternInfo['height'];
        $pattern->bead_type = $patternInfo['bead_type'];
        $pattern->jsonPattern = json_encode($patternInfo['jsonPattern']);
        $pattern->save();
    }

  public function drawPattern(){
      return view('patterns.patternMaker');
  }
}