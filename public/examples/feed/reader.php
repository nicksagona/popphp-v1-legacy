<?php

require_once '../../bootstrap.php';

use Pop\Feed\Reader;

try {
    $feed = new Reader('http://gdata.youtube.com/feeds/base/standardfeeds/most_viewed', 4);

    $htmlTemplate = <<<HTML
    <div>
        <a href="[{link}]"><img src="[{image}]" alt="[{title}]" border="0" /></a><br />
        <a href="[{link}]">[{title}]</a><br />
        <strong>[{pubDate}]</strong> ([{timeElapsed}])<br />
        <p>[{description}]</p>
    </div>

HTML;

    $feed->setTemplate($htmlTemplate);
    $feed->render();
    echo PHP_EOL . PHP_EOL;
} catch (\Exception $e) {
    echo $e->getMessage();
}

