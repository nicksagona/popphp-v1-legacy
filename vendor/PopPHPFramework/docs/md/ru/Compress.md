Pop PHP Framework
=================

Documentation : Compress
------------------------

Home

Ð¡Ð¶Ð°Ñ‚Ð¸Ðµ ÐºÐ¾Ð¼Ð¿Ð¾Ð½ÐµÐ½Ñ‚ Ð¾Ð±ÐµÑ?Ð¿ÐµÑ‡Ð¸Ð²Ð°ÐµÑ‚
Ð½Ð¾Ñ€Ð¼Ð¸Ñ€Ð¾Ð²Ð°Ð½Ð½Ñ‹Ð¹ Ð¼ÐµÑ‚Ð¾Ð´ Ð´Ð»Ñ? Ñ?Ð¶Ð°Ñ‚Ð¸Ñ? Ð¸
Ñ€Ð°Ñ?Ð¿Ð°ÐºÐ¾Ð²ÐºÐ¸ Ñ„Ð°Ð¹Ð»Ð¾Ð² Ð¸ Ð´Ð°Ð½Ð½Ñ‹Ñ… Ñ? Ð¿Ð¾Ð¼Ð¾Ñ‰ÑŒÑŽ
Ð¿Ð¾Ð´Ð´ÐµÑ€Ð¶Ð¸Ð²Ð°ÐµÐ¼Ñ‹Ñ… Ð¼ÐµÑ‚Ð¾Ð´Ð¾Ð²:

-   bzip2
-   gzip & zlib
-   lzf

<!-- -->

    use Pop\Compress\Bzip2;

    $compressed = Bzip2::compress('Some string');
    $uncompressed = Bzip2::uncompress($compressed);

\(c) 2009-2013 [Moc 10 Media, LLC.](http://www.moc10media.com) All
Rights Reserved.
