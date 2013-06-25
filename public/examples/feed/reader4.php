<?php

require_once '../../bootstrap.php';

use Pop\Feed;

try {
    $tmpl = <<<POSTS
    <div class="post-div">
        <a href="[{link}]">[{title}]</a><br />
        <strong>[{published}]</strong> ([{time}])<br />
    </div>

POSTS;

    $twitter = Feed\Reader::getByAccountName('twitter', 'highvoltagenola', 3);
    //$twitter = new Feed\Reader(new Feed\Format\Rss\Twitter(array('name' => 'highvoltagenola'), 3));
    $twitter->setTemplate($tmpl);

    echo '<h1>' . $twitter->title . '</h1>' . PHP_EOL;
    echo '<h4>' . $twitter->tweets . ' Tweets : ' . $twitter->following . ' Following : ' . $twitter->followers . ' Followers</h4>' . PHP_EOL;
    $twitter->render();
} catch (\Exception $e) {
    echo $e->getMessage();
}