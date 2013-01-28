Pop PHP Framework
=================

Documentation : Font
--------------------

Home

Ð¨Ñ€Ð¸Ñ„Ñ‚ ÐºÐ¾Ð¼Ð¿Ð¾Ð½ÐµÐ½Ñ‚Ð° Ð² Ð³Ð»ÑƒÐ±Ð¸Ð½Ðµ Ð°Ð½Ð°Ð»Ð¸Ð·Ð°Ñ‚Ð¾Ñ€
ÑˆÑ€Ð¸Ñ„Ñ‚, ÐºÐ¾Ñ‚Ð¾Ñ€Ñ‹Ð¹ Ð¸Ð·Ð²Ð»ÐµÐºÐ°ÐµÑ‚ Ð²Ð°Ð¶Ð½Ñ‹Ðµ Ð´Ð°Ð½Ð½Ñ‹Ðµ
ÑˆÑ€Ð¸Ñ„Ñ‚Ð° Ð¸ Ð¼ÐµÑ‚Ñ€Ð¸ÐºÐ¸ Ð´Ð»Ñ? Ð´Ñ€ÑƒÐ³Ð¸Ñ…
ÐºÐ¾Ð¼Ð¿Ð¾Ð½ÐµÐ½Ñ‚Ð¾Ð² Ð¸ Ð¿Ñ€Ð¾Ð³Ñ€Ð°Ð¼Ð¼ Ð´Ð»Ñ?
Ð¸Ñ?Ð¿Ð¾Ð»ÑŒÐ·Ð¾Ð²Ð°Ð½Ð¸Ñ?. ÐŸÐ¾Ð´Ð´ÐµÑ€Ð¶Ð¸Ð²Ð°ÐµÐ¼Ñ‹Ðµ Ñ‚Ð¸Ð¿Ñ‹
ÑˆÑ€Ð¸Ñ„Ñ‚Ð¾Ð²:

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
