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
use SVG\SVG;
use SVG\Nodes\Shapes\SVGRect;

class PatternsController extends BaseController
{

    public function showFirst()
    {
        $data['pattern'] = Patterns::first();
        return view('home', $data);
    }

    public function savePattern()
    {
        $patternInfo = Input::all()['returnPattern'];

        $pattern = new Patterns();
        $pattern->width = $patternInfo['width'];
        $pattern->height = $patternInfo['height'];
        $pattern->bead_type = 'delica';

        $patternMatrix = $patternInfo['pattern'];

        //Create a svg of the pattern
        $image = new SVG($pattern->width * 10, $pattern->height * 10);
        $doc = $image->getDocument();

        foreach($patternMatrix as $rowIndex => $row){
            foreach($row as $columnIndex => $bead){
                $square = new SVGRect($rowIndex * 10, $columnIndex * 10, 10, 10);
                $square->setStyle('fill', $bead['color']);
                $doc->addChild($square);
            }
        }

        $pattern->svg_image = $image;
        $pattern->save();

        //this creates the svg image
//        header('Content-Type: image/svg+xml');
//        echo $image;

        //this creates the png image
//        $rasterImage = $image->toRasterImage($pattern->width * 10, $pattern->height * 10);
//        header('Content-Type: image/png');
//        imagepng($rasterImage, 'output.png', 10);
    }

    public function drawPattern()
    {
        return view('patterns.patternMaker');
    }

    public function next()
    {
        return Patterns::all()->random();
    }
}