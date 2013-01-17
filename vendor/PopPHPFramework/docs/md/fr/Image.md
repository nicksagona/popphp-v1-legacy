Pop PHP Framework
=================

Documentation : Image
---------------------

Le composant Image fournit un wrapper API standardisée pour la création et la manipulation d'images qui tire parti de GD de PHP et des extensions Imagick, ainsi que le format d'image SVG. Dans cette composante est une API riche en fonctionnalités pour effectuer de nombreux différents basés sur l'image des fonctions. Et, depuis l'API est normalisée, si un projet se déplace dans un environnement différent, il devrait se dégrader facilement.

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
