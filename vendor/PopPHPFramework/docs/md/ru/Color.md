Pop PHP Framework
=================

Documentation : Color
---------------------

Цвет компонента является полезным компонентом для управления и использования объектов значение цвета. Он также предоставляет функциональные возможности для преобразования значения цвета в других цветовых пространствах, например, преобразования RGB в CMYK.


<pre>
use Pop\Color\Color,
    Pop\Color\Rgb;

$color = new Color(new Rgb(112, 124, 228));
echo $color->cmyk->getCmyk(Color::STRING);
echo $color->lab->getLab(Color::STRING);
</pre>

(c) 2009-2012 [Moc 10 Media, LLC.](http://www.moc10media.com) All Rights Reserved.
