Pop PHP Framework
=================

Documentation : Feed
--------------------

Home

Î— ÏƒÏ…Î½Î¹ÏƒÏ„ÏŽÏƒÎ± Feed Ï€Î±Ï?Î­Ï‡ÎµÎ¹ Ï„Î·
Î»ÎµÎ¹Ï„Î¿Ï…Ï?Î³Î¹ÎºÏŒÏ„Î·Ï„Î± Î³Î¹Î± Î½Î± Î´Î¹Î±Î²Î¬ÏƒÎµÏ„Îµ ÎºÎ±Î¹
Î½Î± Î±Î½Î±Î»Ï?ÏƒÎµÎ¹ ÎµÎ¾Ï‰Ï„ÎµÏ?Î¹ÎºÎ­Ï‚ Ï?Î¿Î­Ï‚ ÎºÎ±Î¹ Î½Î±
Ï€Î±Ï?Î­Ï‡Î¿Ï…Î½ Ï„Î± Î´ÎµÎ´Î¿Î¼Î­Î½Î± ÏƒÎµ Î­Î½Î± Ï‡Ï?Î®ÏƒÎ¹Î¼Î¿
Ï„Ï?ÏŒÏ€Î¿, ÎºÎ±Î¸ÏŽÏ‚ ÎºÎ±Î¹ Ï„Î· Î»ÎµÎ¹Ï„Î¿Ï…Ï?Î³Î¹ÎºÏŒÏ„Î·Ï„Î± Î³Î¹Î±
Î½Î± Î³Ï?Î¬ÏˆÎµÎ¹ ÎºÎ±Î¹ Î½Î± ÎµÎ¼Ï†Î±Î½Î¯ÏƒÎµÎ¹ Ï€ÎµÏ?Î¹ÎµÏ‡ÏŒÎ¼ÎµÎ½Î¿
feeds.

Î•Î´ÏŽ ÎµÎ¯Î½Î±Î¹ Î­Î½Î± Ï€Î±Ï?Î¬Î´ÎµÎ¹Î³Î¼Î± Ï„Î·Ï‚ Î±Î½Î¬Î³Î½Ï‰ÏƒÎ·Ï‚
(Î´Î·Î»Î±Î´Î®, parsing) Î¼Î¹Î± ÎµÎ¾Ï‰Ï„ÎµÏ?Î¹ÎºÎ® Ï„Ï?Î¿Ï†Î¿Î´Î¿ÏƒÎ¯Î±.

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

Î•Î´ÏŽ ÎµÎ¯Î½Î±Î¹ Î­Î½Î± Ï€Î±Ï?Î¬Î´ÎµÎ¹Î³Î¼Î± Î±Ï€ÏŒ Ï„Î·Î½
Î±Î½Î¬Î³Î½Ï‰ÏƒÎ· ÎµÎ½ÏŒÏ‚ Ï„Ï?Î¿Ï†Î¿Î´Î¿ÏƒÎ¯Î±Ï‚ Î±Ï€ÏŒ Î­Î½Î±
Î»Î¿Î³Î±Ï?Î¹Î±ÏƒÎ¼ÏŒ Ï…Ï€Î·Ï?ÎµÏƒÎ¯Î±Ï‚, ÏŒÏ€Ï‰Ï‚ Ï„Î¿ Twitter Î® Ï„Î¿
Facebook.

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

Î•Î´ÏŽ ÎµÎ¯Î½Î±Î¹ Î­Î½Î± Ï€Î±Ï?Î¬Î´ÎµÎ¹Î³Î¼Î± Î³Ï?Î±Ï†Î®Ï‚ ÎµÎ½ÏŒÏ‚
Î¶Ï‰Î¿Ï„Ï?Î¿Ï†ÏŽÎ½.

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
