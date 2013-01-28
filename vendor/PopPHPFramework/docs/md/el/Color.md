Pop PHP Framework
=================

Documentation : Color
---------------------

Home

Î¤Î¿ ÏƒÏ…ÏƒÏ„Î±Ï„Î¹ÎºÏŒ Ï‡Ï?Ï‰Î¼Î¬Ï„Ï‰Î½ ÎµÎ¯Î½Î±Î¹ Î­Î½Î±
Ï‡Ï?Î®ÏƒÎ¹Î¼Î¿ ÏƒÏ„Î¿Î¹Ï‡ÎµÎ¯Î¿ Î³Î¹Î± Ï„Î· Î´Î¹Î±Ï‡ÎµÎ¯Ï?Î¹ÏƒÎ· ÎºÎ±Î¹
Î±Î¾Î¹Î¿Ï€Î¿Î¯Î·ÏƒÎ· Î±Î½Ï„Î¹ÎºÎµÎ¯Î¼ÎµÎ½Î± Î±Î¾Î¯Î±Ï‚ Ï‡Ï?ÏŽÎ¼Î±. Î
Î±Ï?Î­Ï‡ÎµÎ¹ ÎµÏ€Î¯ÏƒÎ·Ï‚ Ï„Î· Î»ÎµÎ¹Ï„Î¿Ï…Ï?Î³Î¹ÎºÏŒÏ„Î·Ï„Î± Î½Î±
Î¼ÎµÏ„Î±Ï„Ï?Î­ÏˆÏ„Îµ Ï„Î¹Ï‚ Ï„Î¹Î¼Î­Ï‚ Ï‡Ï?Ï‰Î¼Î¬Ï„Ï‰Î½ ÏƒÎµ
Î¬Î»Î»Î¿Ï…Ï‚ Ï‡ÏŽÏ?Î¿Ï…Ï‚ Ï‡Ï?ÏŽÎ¼Î±, Î³Î¹Î± Ï€Î±Ï?Î¬Î´ÎµÎ¹Î³Î¼Î±,
Î¼ÎµÏ„Î±Ï„Ï?Î¿Ï€Î® RGB ÏƒÎµ CMYK.

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
