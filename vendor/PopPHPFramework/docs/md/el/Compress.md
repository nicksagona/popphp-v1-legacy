Pop PHP Framework
=================

Documentation : Compress
------------------------

Home

Î¤Î¿ ÏƒÏ„Î¿Î¹Ï‡ÎµÎ¯Î¿ Î£Ï…Î¼Ï€Î¯ÎµÏƒÎ· Ï€Î±Ï?Î­Ï‡ÎµÎ¹ Î¼Î¹Î±
ÎºÎ±Î½Î¿Î½Î¹ÎºÎ¿Ï€Î¿Î¹Î·Î¼Î­Î½Î· Î¼Î­Î¸Î¿Î´Î¿Ï‚ Î³Î¹Î± Ï„Î·
ÏƒÏ…Î¼Ï€Î¯ÎµÏƒÎ· ÎºÎ±Î¹ Î±Ï€Î¿ÏƒÏ…Î¼Ï€Î¯ÎµÏƒÎ· Î´ÎµÎ´Î¿Î¼Î­Î½Ï‰Î½ ÎºÎ±Î¹
Î±Ï?Ï‡ÎµÎ¯Î± Î¼Î­ÏƒÏ‰ Ï„Ï‰Î½ Î¼ÎµÎ¸ÏŒÎ´Ï‰Î½ Ï€Î¿Ï…
Ï…Ï€Î¿ÏƒÏ„Î·Ï?Î¯Î¶Î¿Î½Ï„Î±Î¹:

-   bzip2
-   gzip & zlib
-   lzf

<!-- -->

    use Pop\Compress\Bzip2;

    $compressed = Bzip2::compress('Some string');
    $uncompressed = Bzip2::uncompress($compressed);

\(c) 2009-2013 [Moc 10 Media, LLC.](http://www.moc10media.com) All
Rights Reserved.
