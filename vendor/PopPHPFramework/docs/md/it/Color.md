Pop PHP Framework
=================

Documentation : Color
---------------------

Il componente del colore è una componente utile per gestire e utilizzare gli oggetti di valore di colore. Esso prevede inoltre la funzionalità per convertire i valori di colore agli spazi di colore diversi, per esempio, la conversione da RGB a CMYK.


<pre>
use Pop\Color\Color,
    Pop\Color\Rgb;

$color = new Color(new Rgb(112, 124, 228));
echo $color->cmyk->getCmyk(Color::STRING);
echo $color->lab->getLab(Color::STRING);
</pre>

(c) 2009-2012 [Moc 10 Media, LLC.](http://www.moc10media.com) All Rights Reserved.
