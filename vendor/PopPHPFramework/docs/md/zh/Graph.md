Pop PHP Framework
=================

Documentation : Graph
---------------------

图表组件允许强大的绘图功能，可以利用任何内置的图形组件，如图像，SVG和PDF绘制在各种格式的图形。你可以定义一系列的图形属性，创建和渲染线图，条形图和饼图。由于在不同的图形组件的API规范，它很容易转乘不同的文件，并在其中产生一个图形图像格式之中。

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
