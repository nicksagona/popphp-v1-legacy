Pop PHP Framework
=================

Documentation : Graph
---------------------

Home

El componente de gráficas permite la funcionalidad de gráficos robusto
que puede utilizar cualquiera de los construidos en componentes gráficos
tales como Imagen, SVG y PDF para dibujar gráficos en una variedad de
formatos. Se puede definir una amplia gama de atributos gráficos para
crear y producir gráficos de líneas, gráficos de barras y gráficos
circulares. Dado que la API entre los diferentes componentes gráficos
está estandarizado, es muy fácil de intercambiar entre diferentes
formatos de archivo y la imagen en la que para producir un gráfico.

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
