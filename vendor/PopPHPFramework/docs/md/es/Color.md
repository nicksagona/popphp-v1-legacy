Pop PHP Framework
=================

Documentation : Color
---------------------

El componente de color es un componente útil para gestionar y utilizar los objetos de color de valor. También proporciona la funcionalidad para convertir los valores de color para otros espacios de color, por ejemplo, la conversión de RGB a CMYK.

<pre>
use Pop\Color\Color,
    Pop\Color\Rgb;

$color = new Color(new Rgb(112, 124, 228));
echo $color->cmyk->getCmyk(Color::STRING);
echo $color->lab->getLab(Color::STRING);
</pre>

(c) 2009-2013 [Moc 10 Media, LLC.](http://www.moc10media.com) All Rights Reserved.
