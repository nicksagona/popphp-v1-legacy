Pop PHP Framework
=================

Documentation : Color
---------------------

Die Color-Komponente ist eine nützliche Komponente zu verwalten und zu nutzen Farbwert Objekte. Es bietet auch die Funktionalität, um Farbwerte zu anderen Farbräumen zu konvertieren, zum Beispiel Umwandlung von RGB zu CMYK.

<pre>
use Pop\Color\Color,
    Pop\Color\Rgb;

$color = new Color(new Rgb(112, 124, 228));
echo $color->cmyk->getCmyk(Color::STRING);
echo $color->lab->getLab(Color::STRING);
</pre>

(c) 2009-2012 [Moc 10 Media, LLC.](http://www.moc10media.com) All Rights Reserved.
