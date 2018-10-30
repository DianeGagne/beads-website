<?php
/**
 * Created by PhpStorm.
 * User: Diane
 * Date: 7/3/2017
 * Time: 11:02 PM
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;


class CreateController extends BaseController
{

    /**
     * Take an uploaded file, bead type, size & max colors
     * and create a matrix output of the image in bead form
     */
    public function createFromImage()
    {
        $image = $this->getUploadedImage();

        //get our other requirements for the image processing
        $beadHeight = Request::get('height');
        $beadWidth = Request::get('width');
        $this->getBeadSizes($image, $beadHeight, $beadWidth);

        //Convert the image into a graph image

        //Return an image of the pixelated image to display on the front end, for the user to review

    }

    /**
     * Get the image uploaded to be converted into a pattern
     */
    public function getUploadedImage()
    {
//Get the image from the request
        $image = Request::get('file');
        //Convert the image to a consistent format (bmp)
        //Save the image to a temp file
        //Save the image name to the session

        return $image;
    }

    /**
     * Using the incoming information and image, determine which pixels are represented by each individual bead
     *
     * @param $image
     * @param $beadHeight
     * @param $beadWidth
     */
    public function getBeadSizes($image, $beadHeight, $beadWidth)
    {
//Get the pixel heights
        $pixelHeight = $image->height();
        $pixelWidth = $image->width();

        //Determine if the image is height or width restricted
        $widthRestricted = $pixelHeight / $beadHeight > $pixelWidth / $beadWidth;

        //Get the height and width of each section to be converted to a bead
        $beadSize = $widthRestricted ? $pixelWidth / $beadWidth : $pixelHeight / $beadHeight;

        //Get the starting pixel for the height and width
        $startX = 0;
        if ($widthRestricted) {
            $startX = $pixelHeight - ($beadSize * $beadHeight) / 2;
        }

        $startY = 0;
        if (!$widthRestricted) {
            $startY = $pixelWidth - ($beadSize * $beadWidth) / 2;
        }
    }

    /**
     * Update if the size or type of bead changes.  Use the already uploaded image - saved in a previous request
     * and modify the response to use the new sizes.
     */
    public function updateCreationStats()
    {
//Return an image of the pixelated image to display on the front end, for the user to review
    }
}