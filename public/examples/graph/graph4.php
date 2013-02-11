<?php

require_once '../../bootstrap.php';

use Pop\Color\Space\Rgb;
use Pop\Graph\Graph;

try {
    $pie = array(
        'x' => 320,
        'y' => 240,
        'w' => 200,
        'h' => 100
    );

    $percents = array(
        array(10, new Rgb(200, 15, 15)),
        array(8, new Rgb(80, 5, 10)),
        array(12, new Rgb(80, 180, 100)),
        array(18, new Rgb(50, 125, 210)),
        array(22, new Rgb(80, 180, 10)),
        array(18, new Rgb(100, 125, 210)),
        array(12, new Rgb(80, 180, 10))
    );

    $graph = new Graph(array(
        'filename' => 'graph.gif',
        'width'    => 640,
        'height'   => 480
    ));
    $graph->addFont('../assets/fonts/times.ttf')
          ->setFontColor(new Rgb(128, 128, 128))
          ->showText(true)
          ->createPieChart($pie, $percents, 20)
          ->output();
} catch (\Exception $e) {
    echo $e->getMessage();
}

