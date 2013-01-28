Pop PHP Framework
=================

Documentation : Feed
--------------------

Home

ÐŸÐ¾Ñ‚Ð¾Ðº ÐºÐ¾Ð¼Ð¿Ð¾Ð½ÐµÐ½Ñ‚ Ð¿Ñ€ÐµÐ´Ð¾Ñ?Ñ‚Ð°Ð²Ð»Ñ?ÐµÑ‚
Ñ„ÑƒÐ½ÐºÑ†Ð¸Ð¾Ð½Ð°Ð»ÑŒÐ½Ñ‹Ðµ Ð²Ð¾Ð·Ð¼Ð¾Ð¶Ð½Ð¾Ñ?Ñ‚Ð¸ Ð´Ð»Ñ? Ñ‡Ñ‚ÐµÐ½Ð¸Ñ?
Ð¸ Ð°Ð½Ð°Ð»Ð¸Ð·Ð° Ð²Ð½ÐµÑˆÐ½Ð¸Ñ… ÐºÐ°Ð½Ð°Ð»Ð¾Ð² Ð¸
Ð¿Ñ€ÐµÐ´Ð¾Ñ?Ñ‚Ð°Ð²Ð¸Ñ‚ÑŒ Ð¸Ð½Ñ„Ð¾Ñ€Ð¼Ð°Ñ†Ð¸ÑŽ Ð² Ð¿Ð¾Ð»ÐµÐ·Ð½Ñ‹Ðµ
Ñ?Ð¿Ð¾Ñ?Ð¾Ð±Ð¾Ð¼, Ð° Ñ‚Ð°ÐºÐ¶Ðµ Ñ„ÑƒÐ½ÐºÑ†Ð¸Ð¾Ð½Ð°Ð»ÑŒÐ½Ñ‹Ðµ
Ð²Ð¾Ð·Ð¼Ð¾Ð¶Ð½Ð¾Ñ?Ñ‚Ð¸ Ð´Ð»Ñ? Ð·Ð°Ð¿Ð¸Ñ?Ð¸ Ð¸ Ð¾Ñ‚Ð¾Ð±Ñ€Ð°Ð¶ÐµÐ½Ð¸Ñ?
Ñ?Ð¾Ð´ÐµÑ€Ð¶Ð¸Ð¼Ð¾Ð³Ð¾ ÐºÐ°Ð½Ð°Ð»Ð¾Ð².

Ð’Ð¾Ñ‚ Ð¿Ñ€Ð¸Ð¼ÐµÑ€ Ñ‡Ñ‚ÐµÐ½Ð¸Ñ? (Ñ‚.Ðµ. Ð°Ð½Ð°Ð»Ð¸Ð·Ð°)
Ð²Ð½ÐµÑˆÐ½ÐµÐ³Ð¾ Ð¿Ð¸Ñ‚Ð°Ð½Ð¸Ñ?.

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

Ð’Ð¾Ñ‚ Ð¿Ñ€Ð¸Ð¼ÐµÑ€ Ñ‡Ñ‚ÐµÐ½Ð¸Ñ? Ð»ÐµÐ½Ñ‚Ñ‹ Ð¸Ð· ÑƒÑ‡ÐµÑ‚Ð½Ð¾Ð¹
Ð·Ð°Ð¿Ð¸Ñ?Ð¸ Ñ?Ð»ÑƒÐ¶Ð±Ñ‹, Ñ‚Ð°ÐºÐ¸Ðµ ÐºÐ°Ðº Twitter Ð¸Ð»Ð¸ Facebook.

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

Ð’Ð¾Ñ‚ Ð¿Ñ€Ð¸Ð¼ÐµÑ€ Ð½Ð°Ð¿Ð¸Ñ?Ð°Ð½Ð¸Ñ? ÐºÐ¾Ñ€Ð¼Ð°.

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
