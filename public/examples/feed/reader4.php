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

    $twitter = Feed\Reader::getByAccountId('twitter', '50079850', 3);
    $twitter->setTemplate($tmpl);

    echo '<h1>' . $twitter->title . '</h1>' . PHP_EOL;
    echo '<h4>' . $twitter->tweet_count . ' Tweets : ' . $twitter->following . ' Following : ' . $twitter->followers . ' Followers</h4>' . PHP_EOL;
    $twitter->render();
} catch (\Exception $e) {
    echo $e->getMessage();
}
