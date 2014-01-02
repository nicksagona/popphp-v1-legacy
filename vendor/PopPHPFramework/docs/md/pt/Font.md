Pop PHP Framework
=================

Documentation : Font
--------------------

Home

O componente da fonte é um analisador fonte profundidade que extrai
dados de fontes importantes e métricas para outros componentes e
programas para usar. Os tipos de fontes suportados são:

-   TrueType
-   OpenType
-   Type1

<!-- -->

    use Pop\Font\TrueType;

    $font = new TrueType('fonts/times.ttf');

    // You then have access to all of the parsed font data and metrics.
    echo $font->info->fullName;
    echo $font->bBox->xMin;
    echo $font->bBox->yMin;
    echo $font->bBox->xMax;
    echo $font->bBox->yMax;

\(c) 2009-2014 [Moc 10 Media, LLC.](http://www.moc10media.com) All
Rights Reserved.
