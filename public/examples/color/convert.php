<?php

require_once '../../bootstrap.php';

use Pop\Color;

try {
    $rgb = new Color\Rgb(112, 124, 228);
    $cmyk = Color\Convert::ToCmyk($rgb);
    echo 'RGB: ' . $rgb . ' => CMYK: ' . $cmyk;
} catch (\Exception $e) {
    echo $e->getMessage() . PHP_EOL . PHP_EOL;
}
