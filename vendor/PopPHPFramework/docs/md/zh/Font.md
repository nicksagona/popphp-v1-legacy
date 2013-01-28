Pop PHP Framework
=================

Documentation : Font
--------------------

Home

çš„å­—ä½“ç»„ä»¶æ˜¯ä¸€ä¸ªæ·±å…¥çš„å­—ä½“è§£æž?å™¨ä¸­æ??å?–é‡?è¦?çš„å…¶ä»–ç»„ä»¶å’Œç¨‹åº?ä½¿ç”¨çš„å­—ä½“æ•°æ?®å’ŒæŒ‡æ
‡ã€‚æ”¯æŒ?çš„å­—ä½“ç±»åž‹æ˜¯ï¼š

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
