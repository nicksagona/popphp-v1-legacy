Pop PHP Framework
=================

Documentation : Feed
--------------------

Die Feed-Komponente bietet die Funktionalität zu lesen und zu analysieren, externe Feeds und stellen die Daten in einer nützlichen Weise, sowie die Funktionalität zum Schreiben und Content-Feeds anzuzeigen.

Hier ist ein Beispiel des Lesens (dh Parsen) eine externe Zuführung.

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

Hier ist ein Beispiel für das Schreiben eines Feed.

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
