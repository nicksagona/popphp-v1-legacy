<?php

require_once '../../bootstrap.php';

use Pop\Color\Color,
    Pop\Color\Rgb;

try {
    $cmyk = Color::factory()->convertToCmyk(new Rgb(112, 124, 228));
    print_r($cmyk);
    echo PHP_EOL . PHP_EOL;
} catch (\Exception $e) {
    echo $e->getMessage() . PHP_EOL . PHP_EOL;
}
