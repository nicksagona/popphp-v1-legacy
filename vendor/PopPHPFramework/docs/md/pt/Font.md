Pop PHP Framework
=================

Documentation : Font
--------------------

Home

O componente da fonte Ã© um analisador fonte profundidade que extrai
dados de fontes importantes e mÃ©tricas para outros componentes e
programas para usar. Os tipos de fontes suportados sÃ£o:

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

\(c) 2009-2013 [Moc 10 Media, LLC.](http://www.moc10media.com) All
Rights Reserved.
