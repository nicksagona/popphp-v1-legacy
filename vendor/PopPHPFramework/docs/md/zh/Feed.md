Pop PHP Framework
=================

Documentation : Feed
--------------------

饲料组件提供的功能读取和解析外部供稿和提供一个有用的数据，以及功能编写和显示内容的饲料。

这里是一个阅读的例子（即解析）外部的饲料。

<pre>
use Pop\Feed\Reader;
$feed = new Reader('http://gdata.youtube.com/feeds/base/standardfeeds/most_viewed', 4);

$htmlTemplate = &lt;&lt;&lt;HTML
    &lt;div&gt;
        &lt;a href="[{link}]"&gt;&lt;img src="[{image}]" alt="[{title}]" border="0" /&gt;&lt;/a&gt;&lt;br /&gt;
        &lt;a href="[{link}]"&gt;[{title}]&lt;/a&gt;&lt;br /&gt;
        &lt;strong&gt;[{pubDate}]&lt;/strong&gt; ([{timeElapsed}])&lt;br /&gt;
        &lt;p&gt;[{description}]&lt;/p&gt;
    &lt;/div&gt;

HTML;

$feed->setTemplate($htmlTemplate);
$feed->render();
</pre>

这里有一个撰写提要的例子。

<pre>
use Pop\Dom\Dom,
    Pop\Feed\Writer;

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
$feed = new Writer($feedHeaders, $feedEntries, Dom::ATOM);
$feed->render();
</pre>

(c) 2009-2012 [Moc 10 Media, LLC.](http://www.moc10media.com) All Rights Reserved.
