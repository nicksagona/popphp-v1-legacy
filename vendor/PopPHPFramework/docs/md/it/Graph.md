Pop PHP Framework
=================

Documentation : Graph
---------------------

Home

Il componente grafico consente per la funzionalità grafica robusto che
può utilizzare uno dei componenti predefiniti grafici come immagini, Svg
e Pdf per disegnare grafici in una varietà di formati. È possibile
definire una vasta gamma di attributi grafici per creare ed eseguire il
rendering grafici a linee, istogrammi e grafici a torta. Dal momento che
l'API tra le diverse componenti grafici è standard, è molto facile da
scambiare tra diversi file e formati di immagine in cui per produrre un
grafico.

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
