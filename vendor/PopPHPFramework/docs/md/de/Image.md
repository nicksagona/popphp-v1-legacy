Pop PHP Framework
=================

Documentation : Image
---------------------

Die Image-Komponente bietet eine standardisierte API-Wrapper für die Erstellung und Manipulation von Bildern, die die PHP-GD und Imagick Erweiterungen, sowie das SVG-Bild-Format nutzt. Innerhalb dieser Komponente ist eine feature-rich-API zum Ausführen vieler verschiedener Bild-basierte Funktionen. Und da die API ist standardisiert, wenn ein Projekt bewegt sich auf einem anderen Umfeld, sollte es leicht verschlechtern.

<pre>
use Pop\Color\Rgb,
    Pop\Image\Gd;

$image = new Gd('new-image.jpg', 640, 480, new Rgb(255, 0, 0));
$image->setFillColor(new Rgb(0, 0, 255))
      ->setStrokeColor(new Rgb(255, 255, 255))
      ->setStrokeWidth(3)
      ->addEllipse(320, 240, 150, 75)
      ->output();

$image->destroy();
</pre>

(c) 2009-2013 [Moc 10 Media, LLC.](http://www.moc10media.com) All Rights Reserved.
