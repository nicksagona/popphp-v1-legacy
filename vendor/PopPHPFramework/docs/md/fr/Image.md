Pop PHP Framework
=================

Documentation : Image
---------------------

Home

Le composant Image fournit un wrapper API standard pour la crÃ©ation et
la manipulation des images qui exploite GD de PHP et des extensions
Imagick, ainsi que le format d'image SVG. Au sein de cette composante
est une API riche en fonctionnalitÃ©s pour effectuer de nombreuses
diffÃ©rentes fonctions basÃ©es sur l'image. Et, Ã©tant donnÃ© que l'API
est normalisÃ©, si un projet se dÃ©place dans un environnement
diffÃ©rent, il devrait se dÃ©grader facilement.

    use Pop\Color\Space\Rgb,
        Pop\Image\Gd;

    $image = new Gd('new-image.jpg', 640, 480, new Rgb(255, 0, 0));
    $image->setFillColor(new Rgb(0, 0, 255))
          ->setStrokeColor(new Rgb(255, 255, 255))
          ->setStrokeWidth(3)
          ->drawEllipse(320, 240, 150, 75)
          ->output();

    $image->destroy();

\(c) 2009-2013 [Moc 10 Media, LLC.](http://www.moc10media.com) All
Rights Reserved.
