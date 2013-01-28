Pop PHP Framework
=================

Documentation : Color
---------------------

Home

è‰²æˆ?åˆ†ã?¯è‰²ã?®å€¤ã‚ªãƒ–ã‚¸ã‚§ã‚¯ãƒˆã‚’ç®¡ç?†Â·æ´»ç”¨ã?™ã‚‹ã?Ÿã‚?ã?®ä¾¿åˆ©ã?ªã‚³ãƒ³ãƒ?ãƒ¼ãƒ?ãƒ³ãƒˆã?§ã?™ã€‚ã?¾ã?Ÿã€?RGBã?‹ã‚‰CMYKã?¸ã?®å¤‰æ?›ã?¯ã€?ä¾‹ã?ˆã?°ã€?ä»–ã?®è‰²ç©ºé–“ã?«è‰²ã?®å€¤ã‚’å¤‰æ?›ã?™ã‚‹æ©Ÿèƒ½ã‚’æ??ä¾›ã?—ã?¾ã?™ã€‚

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
