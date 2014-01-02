Pop PHP Framework
=================

Documentation : Font
--------------------

Home

Il componente Font è un tipo di carattere in parser profondità che
estrae i dati dei font e metriche importanti per le altre componenti e
programmi da utilizzare. I tipi di font supportati sono:

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
