<?php
/**
 * Created by PhpStorm.
 * User: Diane
 * Date: 7/3/2017
 * Time: 11:02 PM
 */

namespace App\Http\Controllers;
use Illuminate\Routing\Controller as BaseController;


class CreatePatternController extends BaseController
{
  public function drawPattern(){
      return view('patterns.patternMaker');
  }
}