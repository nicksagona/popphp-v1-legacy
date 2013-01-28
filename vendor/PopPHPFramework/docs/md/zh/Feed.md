Pop PHP Framework
=================

Documentation : Feed
--------------------

Home

æ??ä¾›çš„åŠŸèƒ½ï¼Œè¯»å?–å’Œè§£æž?å¤–éƒ¨é¥²æ–™å’Œä»¥æœ‰ç”¨çš„æ–¹å¼?æ??ä¾›çš„æ•°æ?®ï¼Œä»¥å?Šå†™çš„åŠŸèƒ½å’Œæ˜¾ç¤ºå†…å®¹ï¼Œé¥²æ–™çš„é¥²æ–™æˆ?åˆ†ã€‚

ä¸‹é?¢æ˜¯ä¸€ä¸ªä¾‹å­?è¯»æ•°ï¼ˆå?³è§£æž?ï¼‰å¤–éƒ¨ä¾›ç»™ã€‚

    use Pop\Feed;

    $tmpl = <<<NEWS
        <div class="news-div">
            <a href="[{link}]">[{title}]</a><br />
            <strong>[{published}]</strong> ([{time}])<br />
            <p>[{content}]</p>
        </div>

    NEWS;

    $google = 'http://news.google.com/news?pz=1&cf=all&ned=us&hl=en&topic=h&output=rss';
    $feed = Feed\Reader::getByUrl($google, 3);
    $feed->setTemplate($tmpl);
    $feed->render();

ä¸‹é?¢æ˜¯ä¸€ä¸ªä¾‹å­?é˜…è¯»é¥²æ–™çš„æœ?åŠ¡å¸?æˆ·ï¼Œå¦‚Twitteræˆ–Facebookä¸Šã€‚

    use Pop\Feed;

    $tmpl = <<<POSTS
        <div class="post-div">
            <a href="[{link}]">[{title}]</a><br />
            <strong>[{published}]</strong> ([{time}])<br />
        </div>

    POSTS;

    $twitter = Feed\Reader::getByAccountName('twitter', 'highvoltagenola', 3);
    // OR
    //$twitter = Feed\Reader::getByAccountId('twitter', '50079850', 3);

    $twitter->setTemplate($tmpl);

    echo '<h1>' . $twitter->title . '</h1>' . PHP_EOL;
    echo '<h4>' . $twitter->tweet_count . ' Tweets : ' .
        $twitter->following . ' Following : ' .
        $twitter->followers . ' Followers</h4>' . PHP_EOL;

    $twitter->render();

ä¸‹é?¢æ˜¯ä¸€ä¸ªä¾‹å­?ï¼Œå†™ä¸€ä¸ªé¥²æ–™ã€‚

    use Pop\Feed;

    $feedHeaders = array(
        'title'     => 'Test Feed Title',
        'subtitle'  => 'Test Feed Description',
        'link'      => 'http://www.testfeed.com/',
        'language'  => 'en',
        'updated'   => '2010-01-12 13:01:32',
        'generator' => 'http://www.website.com/',
        'author'    => 'Some Editor'
    );

    $entry1 = array(
        'title'    => 'Entry Title 1',
        'link'     => 'http://www.testfeed.com/entry1',
        'comments' => 'http://www.testfeed.com/entry1#comments',
        'author'   => 'Entry Author 1',
        'updated'  => '2010-01-13 14:12:24',
        'summary'  => 'Entry Desc 1'
    );

    $entry2 = array(
        'title'    => 'Entry Title 2',
        'link'     => 'http://www.testfeed.com/entry2',
        'comments' => 'http://www.testfeed.com/entry2#comments',
        'author'   => 'Entry Author 2',
        'updated'  => '2010-01-12 14:12:24',
        'summary'  => 'Entry Desc 2'
    );

    $entry3 = array(
        'title'    => 'Entry Title 3',
        'link'     => 'http://www.testfeed.com/entry3',
        'comments' => 'http://www.testfeed.com/entry3#comments',
        'author'   => 'Entry Author 3',
        'updated'  => '2010-01-11 14:12:24',
        'summary'  => 'Entry Desc 3'
    );

    $feedEntries = array($entry1, $entry2, $entry3);
    $feed = new Feed\Writer($feedHeaders, $feedEntries, Feed\Writer::ATOM);
    $feed->render();

\(c) 2009-2013 [Moc 10 Media, LLC.](http://www.moc10media.com) All
Rights Reserved.
