Pop PHP Framework
=================

Documentation : Font
--------------------

Home

Der Font Komponente ist ein in der Tiefe font-Parser, der wichtige font
Daten und Metriken für andere Komponenten und Programme zu verwenden
extrahiert. Die unterstützten Schriftarten sind:

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
