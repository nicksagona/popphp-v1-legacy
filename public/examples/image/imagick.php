<?php

require_once '../../bootstrap.php';

use Pop\Color\Rgb,
    Pop\Image\Imagick;

try {
    $imagick = new Imagick('../assets/images/test.jpg');
    $imagick
    //        ->brightness(200)
    //        ->saturation(0)
    //        ->hue(45)
    //        ->level(10, 0.8, 200)
    //        ->flip()
    //        ->contrast(50)
    //        ->sharpen(10, 5)
    //        ->blur(25, 25)
    //        ->setStrokeColor(new Rgb(255, 0, 0))
    //        ->border(10)
    //        ->colorize(new Rgb(255, 255, 0))
    //        ->paint(10)
    //        ->posterize(10)
    //        ->noise()
    //        ->diffuse(10)
            ->invert()
            ->swirl(90)
            ->save('../tmp/test.jpg');

    $imagick->destroy();
    echo 'Image saved.' . PHP_EOL . PHP_EOL;
} catch (\Exception $e) {
    echo $e->getMessage();
}

?>