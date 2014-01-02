Pop PHP Framework
=================

Documentation : Color
---------------------

Home

المكون اللون هو عنصر مفيد في إدارة واستخدام الكائنات قيمة اللون. كما
يوفر وظيفة لتحويل قيم الألوان للون المساحات الأخرى، على سبيل المثال،
تحويل RGB إلى CMYK.

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

\(c) 2009-2014 [Moc 10 Media, LLC.](http://www.moc10media.com) All
Rights Reserved.
