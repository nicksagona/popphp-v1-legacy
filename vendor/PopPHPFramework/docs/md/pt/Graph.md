Pop PHP Framework
=================

Documentation : Graph
---------------------

O componente de gráfico permite a funcionalidade de gráficos robusto que pode utilizar qualquer um dos componentes construído em gráficos, tais como imagem, SVG e PDF para desenhar gráficos numa variedade de formatos. Você pode definir uma vasta gama de atributos gráficos para criar e renderizar gráficos de linha, gráficos de barras e gráficos de pizza. Como a API entre os diferentes componentes gráficos é padronizado, é muito fácil de trocar entre o arquivo diferente e formatos de imagem em que para produzir um gráfico.

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
    array(2013, 175),
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

(c) 2009-2013 [Moc 10 Media, LLC.](http://www.moc10media.com) All Rights Reserved.
