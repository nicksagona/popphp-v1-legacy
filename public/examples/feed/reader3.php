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

    $facebook = Feed\Reader::getByAccountName('facebook', 'highvoltagenola', 3);
    $facebook->setTemplate($tmpl);

    echo '<h1>' . $facebook->title . '</h1>' . PHP_EOL;
    echo '<h4>' . $facebook->likes . ' Likes</h4>' . PHP_EOL;
    $facebook->render();
} catch (\Exception $e) {
    echo $e->getMessage();
}

