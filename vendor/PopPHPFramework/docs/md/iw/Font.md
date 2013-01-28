Pop PHP Framework
=================

Documentation : Font
--------------------

Home

×”×¨×›×™×‘ ×”×•×? ×”×’×•×¤×Ÿ ×‘×’×•×¤×Ÿ ×ž× ×ª×— ×”×¢×•×ž×§ ×©×ž×—×œ×¦×ª
× ×ª×•× ×™ ×’×•×¤× ×™×? ×•×ž×“×“×™×? ×—×©×•×‘×™×? ×¢×‘×•×¨ ×¨×›×™×‘×™×?
×•×ª×•×›× ×™×•×ª ×œ×©×™×ž×•×© ×?×—×¨×™×?. ×?×ª ×¡×•×’×™ ×”×’×•×¤× ×™×?
×”× ×ª×ž×›×™×? ×”×?:

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
