Pop PHP Framework
=================

Documentation : Color
---------------------

Home

è‰²å·®åˆ†é‡?æ˜¯ä¸€ä¸ªæœ‰ç”¨çš„ç»„ä»¶ï¼Œç®¡ç?†å’Œä½¿ç”¨çš„é¢œè‰²å€¼å¯¹è±¡ã€‚å®ƒè¿˜æ??ä¾›äº†åŠŸèƒ½è½¬æ?¢åˆ°å…¶ä»–é¢œè‰²ç©ºé—´çš„é¢œè‰²å€¼ï¼Œä¾‹å¦‚ï¼Œå°†RGBè½¬æ?¢ä¸ºCMYKã€‚

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
