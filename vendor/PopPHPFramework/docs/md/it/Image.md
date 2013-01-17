Pop PHP Framework
=================

Documentation : Image
---------------------

Il componente immagine fornisce un wrapper standard API per la creazione e la manipolazione di immagini che sfrutta PHP GD ed estensioni imagick, così come il formato di immagine SVG. All'interno di questo componente è una caratteristica-ricco set di API per l'esecuzione di molteplici funzioni di image-based. E, dal momento che l'API è standardizzato, se un progetto si muove in un ambiente diverso, dovrebbe degradare facilmente.

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
