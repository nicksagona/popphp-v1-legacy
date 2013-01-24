<?php

require_once '../../bootstrap.php';

use Pop\Feed\Reader;

try {
    $tmpl = <<<VIDEOS
    <div class="video-div">
        <a href="[{link}]"><img src="[{image_thumb}]" alt="[{title}]" border="0" /></a><br />
        <a href="[{link}]">[{title}]</a><br />
        <strong>[{published}]</strong> ([{time}])<br />
        [{likes}] Likes<br /><br />
    </div>

VIDEOS;

    $feed = Reader::getByUrl('http://gdata.youtube.com/feeds/base/standardfeeds/most_viewed', 3);
    $feed->setTemplate($tmpl);
    $feed->render();
} catch (\Exception $e) {
    echo $e->getMessage();
}

