Pop PHP Framework
=================

Documentation : Color
---------------------

颜色分量是一个有用的成分，管理和使用的颜色值对象。它还提供了其他的色彩空间转换颜色值，例如，转换RGB到CMYK的功能。

<pre>
use Pop\Color\Color,
    Pop\Color\Rgb;

$color = new Color(new Rgb(112, 124, 228));
echo $color->cmyk->getCmyk(Color::STRING);
echo $color->lab->getLab(Color::STRING);
</pre>

(c) 2009-2013 [Moc 10 Media, LLC.](http://www.moc10media.com) All Rights Reserved.
