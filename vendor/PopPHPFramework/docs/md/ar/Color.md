Pop PHP Framework
=================

Documentation : Color
---------------------

Home

Ø§Ù„Ù…ÙƒÙˆÙ† Ø§Ù„Ù„ÙˆÙ† Ù‡Ùˆ Ø¹Ù†ØµØ± Ù…Ù?ÙŠØ¯ Ù?ÙŠ Ø¥Ø¯Ø§Ø±Ø©
ÙˆØ§Ø³ØªØ®Ø¯Ø§Ù… Ø§Ù„ÙƒØ§Ø¦Ù†Ø§Øª Ù‚ÙŠÙ…Ø© Ø§Ù„Ù„ÙˆÙ†. ÙƒÙ…Ø§ ÙŠÙˆÙ?Ø±
ÙˆØ¸ÙŠÙ?Ø© Ù„ØªØ­ÙˆÙŠÙ„ Ù‚ÙŠÙ… Ø§Ù„Ø£Ù„ÙˆØ§Ù† Ù„Ù„ÙˆÙ† Ø§Ù„Ù…Ø³Ø§Ø­Ø§Øª
Ø§Ù„Ø£Ø®Ø±Ù‰ØŒ Ø¹Ù„Ù‰ Ø³Ø¨ÙŠÙ„ Ø§Ù„Ù…Ø«Ø§Ù„ØŒ ØªØ­ÙˆÙŠÙ„ RGB Ø¥Ù„Ù‰
CMYK.

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
