Pop PHP Framework
=================

Documentation : Image
---------------------

Home

Il componente Immagine fornisce un wrapper standard API per la creazione
e la manipolazione di immagini che sfrutta PHP GD ed estensioni imagick,
così come il formato immagine SVG. All'interno di questo componente è un
ricco di funzionalità API per l'esecuzione di molteplici funzioni basati
su immagini. E, poiché l'API è standardizzato, se un progetto si sposta
in un ambiente diverso, dovrebbe degradare facilmente.

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
