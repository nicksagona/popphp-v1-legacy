Pop PHP Framework
=================

Documentation : Image
---------------------

Home

Die Image-Komponente bietet eine standardisierte API-Wrapper für die
Erstellung und Bearbeitung von Bildern, die PHP GD und Imagick
Erweiterungen, sowie die SVG-Bildformat nutzt. Innerhalb dieser
Komponente ist eine feature-rich API für die Durchführung viele
verschiedene Bild-basierte Funktionen. Und, da die API standardisiert
ist, wenn ein Projekt bewegt sich in eine andere Umgebung, sollte es
leicht verschlechtern.

    use Pop\Color\Space\Rgb,
        Pop\Image\Gd;

    $image = new Gd('new-image.jpg', 640, 480, new Rgb(255, 0, 0));
    $image->setFillColor(new Rgb(0, 0, 255))
          ->setStrokeColor(new Rgb(255, 255, 255))
          ->setStrokeWidth(3)
          ->drawEllipse(320, 240, 150, 75)
          ->output();

    $image->destroy();

\(c) 2009-2014 [Moc 10 Media, LLC.](http://www.moc10media.com) All
Rights Reserved.
