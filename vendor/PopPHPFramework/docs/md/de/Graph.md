Pop PHP Framework
=================

Documentation : Graph
---------------------

Home

Der Graph-Komponente ermöglicht eine robuste Grafik-Funktionen, die
einem der in grafischen Komponenten wie Image aufgebaut nutzen können,
um SVG und Pdf Grafiken in einer Vielzahl von Formaten zu zeichnen. Sie
können eine breite Palette von Grafik-Attribute zu erstellen und zu
rendern Liniendiagramme, Balkendiagramme und Kreisdiagramme. Da die API
zwischen den verschiedenen grafischen Komponenten standardisiert ist,
ist es sehr einfach, zwischen verschiedenen der Datei-und Bildformaten,
in denen eine Grafik zu erzeugen vertauschen.

    use Pop\Color\Space\Rgb,
        Pop\Graph\Graph;

    $x = array('1995', '2000', '2005', '2010', '2015');
    $y = array('0M', '50M', '100M', '150M', '200M');

    $data = array(
        array(1995, 0),
        array(1997, 35),
        array(1998, 25),
        array(2002, 100),
        array(2004, 84),
        array(2006, 98),
        array(2007, 76),
        array(2010, 122),
        array(2012, 175),
        array(2015, 162)
    );


    $graph = new Graph(array(
        'filename' => 'graph.gif',
        'width'    => 640,
        'height'   => 480
    ));

    $graph->addFont('../assets/fonts/times.ttf')
          ->setFontColor(new Rgb(128, 128, 128))
          ->setFillColor(new Rgb(10, 125, 210))
          ->showY(true)
          ->showText(true)
          ->createLineGraph($data, $x, $y)
          ->output();

\(c) 2009-2014 [Moc 10 Media, LLC.](http://www.moc10media.com) All
Rights Reserved.
