Pop PHP Framework
=================

Documentation : Color
---------------------

La composante de couleur est un élément utile pour gérer et utiliser les objets de valeur de couleur. Il fournit également la fonctionnalité de convertir des valeurs de couleur à des espaces de couleurs autres, par exemple, la conversion RVB en CMJN.


<pre>
use Pop\Color\Color,
    Pop\Color\Rgb;

$color = new Color(new Rgb(112, 124, 228));
echo $color->cmyk->getCmyk(Color::STRING);
echo $color->lab->getLab(Color::STRING);
</pre>

(c) 2009-2012 [Moc 10 Media, LLC.](http://www.moc10media.com) All Rights Reserved.
