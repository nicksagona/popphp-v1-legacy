<?php

require_once '../../bootstrap.php';

use Pop\Color\Rgb,
    Pop\Image\Svg;

try {
    $points = array(
        array('x' => 320, 'y' => 50),
        array('x' => 400, 'y' => 100),
        array('x' => 420, 'y' => 200),
        array('x' => 280, 'y' => 320),
        array('x' => 200, 'y' => 180)
    );

    $image = new Svg('new-image.svg', 640, 480, new Rgb(255, 0, 0));
    $image->setFillColor(new Rgb(0, 0, 255))
          ->setStrokeColor(new Rgb(255, 255, 255))
          ->setStrokeWidth(3)
          //->addRectangle(320, 240, 150, 75)
          //->addCircle(320, 240, 150)
          //->addEllipse(320, 240, 150, 75)
          //->addArc(320, 240, 0, 120, 150, 75)
          ->addPolygon($points)
          ->output();

} catch (\Exception $e) {
    echo $e->getMessage();
}

?>