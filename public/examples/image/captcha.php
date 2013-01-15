<?php

require_once '../../bootstrap.php';

use Pop\Image\Captcha;

try {
    $options = array(
        'width'  => 110,
        'height' => 30
    );

    //$options = array(
    //    'image' => '../assets/images/captcha-sm.gif'
    //);

    //$captcha = new Captcha($options, Captcha::FORCE_GD);
    $captcha = new Captcha($options);
    $captcha->setSize(24)
            ->setLength(6)
            ->setXY(5, 30)
            ->setRotate(-7)
            ->setSwirl(20)
            ->setFont('../assets/fonts/times.ttf')
            ->output();
} catch (\Exception $e) {
    echo $e->getMessage();
}

