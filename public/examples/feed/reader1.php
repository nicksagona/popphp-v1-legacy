<?php

require_once '../../bootstrap.php';

use Pop\Feed\Reader;

try {
    $tmpl = <<<NEWS
    <div class="news-div">
        <a href="[{link}]">[{title}]</a><br />
        <strong>[{published}]</strong> ([{time}])<br />
        <p>[{description}]</p>
    </div>

NEWS;

    $feed = new Reader('http://news.google.com/news?pz=1&cf=all&ned=us&hl=en&topic=h&output=rss', 3);
    $feed->setTemplate($tmpl);
    $feed->render();
} catch (\Exception $e) {
    echo $e->getMessage();
}

