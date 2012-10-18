<?php

require_once '../../bootstrap.php';

use Pop\Color\Color,
    Pop\Color\Rgb;

try {
    $color = new Color(new Rgb(112, 124, 228));

    echo '<strong>CMYK conversion:</strong> ' . $color->cmyk->getCmyk(Color::STRING) . PHP_EOL;
    echo '<strong>Lab conversion:</strong> ' . $color->lab->getLab(Color::STRING) . PHP_EOL . PHP_EOL;

    print_r($color);
    echo PHP_EOL . PHP_EOL;
} catch (\Exception $e) {
    echo $e->getMessage() . PHP_EOL . PHP_EOL;
}
