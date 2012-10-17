<?php

require_once '../../bootstrap.php';

use Pop\Color\Rgb,
    Pop\Filter\String,
    Pop\Image\Gd;

try {
    $str = String::random(6, String::ALPHANUM, String::UPPER);
    $image = new Gd('../assets/images/captcha_sm.gif');
    $image->text($str, 20, 20, 40, '../assets/fonts/times.ttf', 10)
          ->output();

    $image->destroy();
} catch (\Exception $e) {
    echo $e->getMessage();
}

?>