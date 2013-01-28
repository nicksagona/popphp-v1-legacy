Pop PHP Framework
=================

Documentation : Font
--------------------

Home

ãƒ•ã‚©ãƒ³ãƒˆã‚³ãƒ³ãƒ?ãƒ¼ãƒ?ãƒ³ãƒˆã?¯ä»–ã?®ã‚³ãƒ³ãƒ?ãƒ¼ãƒ?ãƒ³ãƒˆã?¨ã€?ä½¿ç”¨ã?™ã‚‹ãƒ—ãƒ­ã‚°ãƒ©ãƒ
ã?®ã?Ÿã‚?ã?®é‡?è¦?ã?ªãƒ•ã‚©ãƒ³ãƒˆãƒ‡ãƒ¼ã‚¿ã?¨ãƒ¡ãƒˆãƒªãƒƒã‚¯ã‚’æŠ½å‡ºå¥¥è¡Œã??ãƒ•ã‚©ãƒ³ãƒˆãƒ‘ãƒ¼ã‚¶ã?§ã?‚ã‚‹ã€‚ã‚µãƒ?ãƒ¼ãƒˆã?•ã‚Œã?¦ã?„ã‚‹ãƒ•ã‚©ãƒ³ãƒˆã?®ç¨®é¡žã?¯æ¬¡ã?®ã?¨ã?Šã‚Šã?§ã?™ã€‚

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
