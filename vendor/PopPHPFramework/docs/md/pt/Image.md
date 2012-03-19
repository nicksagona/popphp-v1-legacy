Pop PHP Framework
=================

Documentation : Image
---------------------

O componente de imagem fornece um invólucro API normalizado para a criação e manipulação de imagens que alavanca GD do PHP e extensões Imagick, bem como o formato de imagem SVG. Dentro deste componente é um API característica-rico para a realização de muitos diferentes baseadas na imagem funções. E, uma vez que a API é padronizado, se um projeto se move para um ambiente diferente, deve degradar facilmente.


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

(c) 2009-2012 [Moc 10 Media, LLC.](http://www.moc10media.com) All Rights Reserved.
