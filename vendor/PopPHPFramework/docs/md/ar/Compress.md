Pop PHP Framework
=================

Documentation : Compress
------------------------

Home

Ø§Ù„Ù…ÙƒÙˆÙ† Ø¶ØºØ· ÙŠÙˆÙ?Ø± Ø·Ø±ÙŠÙ‚Ø© Ø·Ø¨ÙŠØ¹ÙŠØ© Ù„Ø¶ØºØ·
ÙˆØ¥Ù„ØºØ§Ø¡ Ø¶ØºØ· Ø§Ù„Ø¨ÙŠØ§Ù†Ø§Øª ÙˆØ§Ù„Ù…Ù„Ù?Ø§Øª Ø¹Ù† Ø·Ø±ÙŠÙ‚
Ø§Ù„Ø£Ø³Ø§Ù„ÙŠØ¨ Ø§Ù„Ù…Ø¹ØªÙ…Ø¯Ø©:

-   bzip2
-   gzip & zlib
-   lzf

<!-- -->

    use Pop\Compress\Bzip2;

    $compressed = Bzip2::compress('Some string');
    $uncompressed = Bzip2::uncompress($compressed);

\(c) 2009-2013 [Moc 10 Media, LLC.](http://www.moc10media.com) All
Rights Reserved.
