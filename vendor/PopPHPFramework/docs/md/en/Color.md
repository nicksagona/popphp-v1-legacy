Pop PHP Framework
=================

Documentation : Color
---------------------

The Color component is a useful component to manage and utilize color value objects. It also provides the functionality to convert color values to other color spaces, for example, converting RGB to CMYK.

<pre>
use Pop\Color\Color,
    Pop\Color\Rgb;

$color = new Color(new Rgb(112, 124, 228));
echo $color->cmyk->getCmyk(Color::STRING);
echo $color->lab->getLab(Color::STRING);
</pre>

(c) 2009-2013 [Moc 10 Media, LLC.](http://www.moc10media.com) All Rights Reserved.
