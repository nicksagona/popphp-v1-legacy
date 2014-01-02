Pop PHP Framework
=================

Documentation : Graph
---------------------

Home

График компонент позволяет надежной функциональностью графического,
который может использовать любой из встроенных в графические компоненты,
такие как изображения, SVG и PDF Для графики в различные форматы. Вы
можете определить широкий спектр графических атрибутов, чтобы создать и
сделать линейные графики, гистограммы и круговые диаграммы. Поскольку
API между различными графическими компонентами стандартизированы, это
очень легко поменять среди различных файлов и изображений форматов, в
которых для получения графика.

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
