<?php

require_once '../../bootstrap.php';

use Pop\Feed;

try {
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
} catch (\Exception $e) {
    echo $e->getMessage();
}

