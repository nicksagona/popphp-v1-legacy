<?php

require_once '../../bootstrap.php';

use Pop\Color;

try {
    $rgb = new Color\Space\Rgb(112, 124, 228);
    $cmyk = Color\Convert::toCmyk($rgb);
    echo 'RGB: ' . $rgb . ' => CMYK: ' . $cmyk;
} catch (\Exception $e) {
    echo $e->getMessage() . PHP_EOL . PHP_EOL;
}
