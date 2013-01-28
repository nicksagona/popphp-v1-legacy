Pop PHP Framework
=================

Documentation : Font
--------------------

Home

Ø§Ù„Ù…ÙƒÙˆÙ† Ø§Ù„Ø®Ø· Ù‡Ùˆ Ø§Ù„Ø®Ø· Ù…Ø­Ù„Ù„ Ù?ÙŠ Ø¹Ù…Ù‚ Ø§Ù„Ø®Ø·
Ø§Ù„Ø°ÙŠ ÙŠØ³ØªØ®Ø±Ø¬ Ø§Ù„Ø¨ÙŠØ§Ù†Ø§Øª Ø§Ù„Ù‡Ø§Ù…Ø© ÙˆØ§Ù„Ù…Ù‚Ø§ÙŠÙŠØ³
Ù„Ù„Ù…ÙƒÙˆÙ†Ø§Øª ÙˆØ§Ù„Ø¨Ø±Ø§Ù…Ø¬ Ø§Ù„Ø£Ø®Ø±Ù‰ Ù„Ù„Ø§Ø³ØªØ®Ø¯Ø§Ù….
Ø£Ù†ÙˆØ§Ø¹ Ø§Ù„Ø®Ø· Ø§Ù„Ù…Ø¹ØªÙ…Ø¯Ø© Ù‡ÙŠ:

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
