Pop PHP Framework
=================

Documentation : Graph
---------------------

Home

O componente Gráfico permite a funcionalidade gráfica robusta que pode
utilizar qualquer um dos componentes construído em gráficos, tais como
imagens, e Svg Pdf para desenhar gráficos em uma variedade de formatos.
Você pode definir uma grande variedade de atributos gráficos para criar
e renderizar gráficos de linha, gráficos de barras e gráficos de pizza.
Como a API entre os diferentes componentes gráficos é padronizado, é
muito fácil de trocar entre os diferentes arquivos e formatos de imagem
em que para produzir um gráfico.

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
