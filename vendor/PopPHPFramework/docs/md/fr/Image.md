Pop PHP Framework
=================

Documentation : Image
---------------------

Home

Le composant Image fournit un wrapper API standard pour la création et
la manipulation des images qui exploite GD de PHP et des extensions
Imagick, ainsi que le format d'image SVG. Au sein de cette composante
est une API riche en fonctionnalités pour effectuer de nombreuses
différentes fonctions basées sur l'image. Et, étant donné que l'API est
normalisé, si un projet se déplace dans un environnement différent, il
devrait se dégrader facilement.

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
