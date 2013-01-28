Pop PHP Framework
=================

Documentation : Image
---------------------

Home

O componente de imagem fornece um invÃ³lucro API padronizada para a
criaÃ§Ã£o e manipulaÃ§Ã£o de imagens que utiliza GD do PHP e extensÃµes
Imagick, bem como o formato de imagem SVG. Dentro deste componente Ã© um
API rico em recursos para a realizaÃ§Ã£o de diversas funÃ§Ãµes baseados
em imagem. E, desde que a API Ã© padronizado, se um projeto se desloca
para um ambiente diferente, ele deve degradar facilmente.

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
