Pop PHP Framework
=================

Documentation : Image
---------------------

El componente de imagen proporciona un contenedor API normalizado para la creación y manipulación de imágenes que aprovecha GD PHP y extensiones Imagick, así como el formato de imagen SVG. Dentro de este componente es una API rica en características para la realización de diversas funciones basadas en imágenes. Y, dado que la API está estandarizado, si un proyecto se traslada a un entorno diferente, se debe degradar fácilmente.

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
