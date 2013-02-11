<?php

require_once '../../bootstrap.php';

use Pop\Color\Space\Rgb;
use Pop\Image\Gd;

try {
    $points = array(
        array('x' => 320, 'y' => 50),
        array('x' => 400, 'y' => 100),
        array('x' => 420, 'y' => 200),
        array('x' => 280, 'y' => 320),
        array('x' => 200, 'y' => 180)
    );

    $image = new Gd('new-image.jpg', 640, 480, new Rgb(255, 0, 0));
    $image->setFillColor(new Rgb(0, 0, 255))
          ->setStrokeColor(new Rgb(255, 255, 255))
          ->setStrokeWidth(3)
          //->setOpacity(50)
          //->drawRectangle(320, 240, 150, 75)
          //->drawCircle(320, 240, 150)
          //->drawEllipse(320, 240, 150, 75)
          //->drawArc(320, 240, 0, 120, 150, 75)
          ->drawPolygon($points)
          ->output();

    // Calling the destructor destroys the image resource as well
    unset($image);
} catch (\Exception $e) {
    echo $e->getMessage();
}

