Pop PHP Framework
=================

Documentation : Cache
---------------------

Home

Ø§Ù„Ø¹Ù†ØµØ± Ø°Ø§ÙƒØ±Ø© Ø§Ù„ØªØ®Ø²ÙŠÙ† Ø§Ù„Ù…Ø¤Ù‚Øª ÙŠØ³Ù…Ø­
Ù„Ø³Ù‡ÙˆÙ„Ø© Ø§Ù„ØªØ®Ø²ÙŠÙ† Ù„Ù„Ø¨ÙŠØ§Ù†Ø§Øª Ø§Ù„Ø«Ø§Ø¨ØªØ© Ø¹Ø¨Ø±
Ø£Ø±Ø¨Ø¹Ø© Ø£Ø³Ø§Ù„ÙŠØ¨:

-   Apc
-   a file on disk
-   a Sqlite database
-   Memcache

ÙˆØ§Ù„Ù‡Ø¯Ù? Ù…Ù† Ù‡Ø°Ø§ Ø§Ù„Ù…ÙƒÙˆÙ† Ù‡Ùˆ Ø§Ù„ÙƒØ§Ø´ Ù„ØªØ³Ø±ÙŠØ¹
Ø§Ù„ÙˆØµÙˆÙ„ Ø¥Ù„Ù‰ Ø§Ù„Ø¨ÙŠØ§Ù†Ø§Øª Ø§Ù„ØªÙŠ Ù‡ÙŠ Ø£ÙƒØ«Ø± Ø«Ø§Ø¨Øª
Ù„Ø§ ÙŠØªØºÙŠØ± ÙˆÙƒØ«ÙŠØ± Ù…Ù† Ø§Ù„Ø£Ø­ÙŠØ§Ù†. Ø¹Ù† Ø·Ø±ÙŠÙ‚ ØªØ®Ø²ÙŠÙ†
Ù…Ù† Ù‚Ø¨Ù„ Ø¥Ø­Ø¯Ù‰ Ø§Ù„Ø·Ø±Ù‚ Ø§Ù„Ù…Ø°ÙƒÙˆØ±Ø© Ø£Ø¹Ù„Ø§Ù‡ØŒ ÙŠÙ…ÙƒÙ†
Ø²ÙŠØ§Ø¯Ø© Ø§Ù„Ø³Ø±Ø¹Ø© Ù„Ø£Ù†Ù‡ ÙŠÙ…ÙƒÙ† ØªØ¬Ù†Ø¨ Ù…ÙƒØ§Ù„Ù…Ø©
Ø¹Ù…Ù„ÙŠØ© Ø£ÙƒØ«Ø± ØªÙƒÙ„Ù?Ø©ØŒ Ù…Ø«Ù„ Ø§Ù„ÙˆØµÙˆÙ„ Ø¥Ù„Ù‰ Ù‚Ø§Ø¹Ø¯Ø©
Ø¨ÙŠØ§Ù†Ø§Øª ÙƒØ¨ÙŠØ±Ø© Ø£Ùˆ Ø¹Ù†ÙˆØ§Ù† ÙˆÙŠØ¨ Ù„Ø§Ø³ØªØ±Ø¯Ø§Ø¯
Ø§Ù„Ø¨ÙŠØ§Ù†Ø§Øª Ø§Ù„Ø®Ø§Ø±Ø¬ÙŠØ©

    use Pop\Cache;
    $test = 'This is my test variable. It contains a string.';

    $cache = Cache\Cache::factory(new Cache\Adapter\File('../tmp'), 30);
    //$cache = Cache\Cache::factory(new Cache\Adapter\Memcached(), 30);
    //$cache = Cache\Cache::factory(new Cache\Adapter\Sqlite('../tmp/cache.sqlite'), 30);
    //$cache = Cache\Cache::factory(new Cache\Adapter\Apc(), 30);

    $cache->save('test', $test);

    // Load the value
    if (!($var = $cache->load('test'))) {
        echo "It's either not there or expired.";
    } else {
        echo $var;
    }

    // Clear the cache
    $cache->clear();

\(c) 2009-2013 [Moc 10 Media, LLC.](http://www.moc10media.com) All
Rights Reserved.
