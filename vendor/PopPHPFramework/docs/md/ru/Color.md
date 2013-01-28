Pop PHP Framework
=================

Documentation : Color
---------------------

Home

Ð¦Ð²ÐµÑ‚ ÐºÐ¾Ð¼Ð¿Ð¾Ð½ÐµÐ½Ñ‚Ð° Ñ?Ð²Ð»Ñ?ÐµÑ‚Ñ?Ñ? Ð¿Ð¾Ð»ÐµÐ·Ð½Ñ‹Ð¼
ÐºÐ¾Ð¼Ð¿Ð¾Ð½ÐµÐ½Ñ‚Ð¾Ð¼ Ð´Ð»Ñ? ÑƒÐ¿Ñ€Ð°Ð²Ð»ÐµÐ½Ð¸Ñ? Ð¸
Ð¸Ñ?Ð¿Ð¾Ð»ÑŒÐ·Ð¾Ð²Ð°Ð½Ð¸Ñ? Ð¾Ð±ÑŠÐµÐºÑ‚Ð¾Ð² Ð·Ð½Ð°Ñ‡ÐµÐ½Ð¸Ðµ Ñ†Ð²ÐµÑ‚Ð°.
ÐžÐ½ Ñ‚Ð°ÐºÐ¶Ðµ Ð¿Ñ€ÐµÐ´Ð¾Ñ?Ñ‚Ð°Ð²Ð»Ñ?ÐµÑ‚ Ñ„ÑƒÐ½ÐºÑ†Ð¸Ð¾Ð½Ð°Ð»ÑŒÐ½Ñ‹Ðµ
Ð²Ð¾Ð·Ð¼Ð¾Ð¶Ð½Ð¾Ñ?Ñ‚Ð¸ Ð´Ð»Ñ? Ð¿Ñ€ÐµÐ¾Ð±Ñ€Ð°Ð·Ð¾Ð²Ð°Ð½Ð¸Ñ?
Ñ†Ð²ÐµÑ‚Ð¾Ð²Ñ‹Ñ… Ð·Ð½Ð°Ñ‡ÐµÐ½Ð¸Ð¹ Ð´Ñ€ÑƒÐ³Ð¸Ñ… Ñ†Ð²ÐµÑ‚Ð¾Ð²Ñ‹Ñ…
Ð¿Ñ€Ð¾Ñ?Ñ‚Ñ€Ð°Ð½Ñ?Ñ‚Ð², Ð½Ð°Ð¿Ñ€Ð¸Ð¼ÐµÑ€, Ð¿Ñ€ÐµÐ¾Ð±Ñ€Ð°Ð·Ð¾Ð²Ð°Ð½Ð¸Ñ?
RGB Ð² CMYK.

    use Pop\Color;

    // Create a color space value object
    $color = new Color\Color(new Color\Space\Rgb(112, 124, 228));

    echo '<strong>RGB values:</strong> ' . $color->rgb . '<br /><br />' . PHP_EOL;
    echo '<strong>HEX values:</strong> ' . $color->hex . '<br /><br />' . PHP_EOL;
    echo '<strong>CMYK conversion:</strong> ' . $color->cmyk . '<br /><br />' . PHP_EOL;
    echo '<strong>HSB conversion:</strong> ' . $color->hsb . '<br /><br />' . PHP_EOL;
    echo '<strong>Lab conversion:</strong> ' . $color->lab . '<br /><br />' . PHP_EOL;

    // Directly convert a single color object
    $rgb = new Color\Space\Rgb(112, 124, 228);
    $cmyk = Color\Convert::toCmyk($rgb);
    echo 'RGB: ' . $rgb . ' => CMYK: ' . $cmyk;

\(c) 2009-2013 [Moc 10 Media, LLC.](http://www.moc10media.com) All
Rights Reserved.
