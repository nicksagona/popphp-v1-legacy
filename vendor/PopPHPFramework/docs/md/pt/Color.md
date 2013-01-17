Pop PHP Framework
=================

Documentation : Color
---------------------

O componente de cor é um componente útil para gerenciar e utilizar objetos de valor de cor. Ele também fornece a funcionalidade para converter valores de cor para outros espaços de cor, por exemplo, converter RGB para CMYK.

<pre>
use Pop\Color\Color,
    Pop\Color\Rgb;

$color = new Color(new Rgb(112, 124, 228));
echo $color->cmyk->getCmyk(Color::STRING);
echo $color->lab->getLab(Color::STRING);
</pre>

(c) 2009-2013 [Moc 10 Media, LLC.](http://www.moc10media.com) All Rights Reserved.
