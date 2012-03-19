Pop PHP Framework
=================

Documentation : Graph
---------------------

El componente gráfico permite la funcionalidad de gráficos robusta que puede utilizar cualquiera de los construidos en los componentes gráficos, como imágenes, SVG y PDF para dibujar gráficos en una variedad de formatos. Se puede definir una amplia gama de atributos gráficos para crear y producir gráficos de líneas, gráficos de barras y gráficos circulares. Desde la API entre los diferentes componentes gráficos está estandarizado, es muy fácil de intercambiar entre los diferentes el archivo y los formatos de imagen en la que para producir un gráfico.

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
