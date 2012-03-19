Pop PHP Framework
=================

Documentation : Graph
---------------------

График компонент позволяет надежную функциональность графической, которые могут использовать любой из встроенных графических компонентов, таких как изображения, SVG и Pdf для рисования графиков в различных форматах. Вы можете определить широкий спектр графических атрибутов для создания и оказывают линейные графики, гистограммы и круговые диаграммы. Поскольку API между различными графическими компонентами стандартизированы, это очень легко обмениваться между различными файлов и изображений форматов, в которых для получения графика.


<pre>
use Pop\Color\Rgb,
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

$graph = new Graph('graph.gif', 640, 480, Graph::IMAGICK);
//$graph = new Graph('graph.svg', 640, 480);
$graph->addFont('../assets/fonts/times.ttf')
      ->setFontColor(new Rgb(128, 128, 128))
      ->setFillColor(new Rgb(10, 125, 210))
      ->showY(true)
      ->showText(true)
      ->addLineGraph($data, $x, $y)
      ->output();
</pre>

(c) 2009-2012 [Moc 10 Media, LLC.](http://www.moc10media.com) All Rights Reserved.
