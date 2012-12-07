<?php

require_once '../../bootstrap.php';

use Pop\Event\Handler;

try {
    $events = new Handler('dispatch.pre', 'Test event 123.');
    $events->attach('render.post', 'This is a post event.')
           ->attach('blah.pre.', 'This is a pre event.')
           ->attach('another.post.app', 'This is another post event.')
           ->attach('something.pre.app.users', 'This is yet another pre event.')
           ->attach('somethingelse.post.app.users', 'This is one more post event.');

    print_r($events);

    echo '<br />' . PHP_EOL;

    if ($events->hasPre()) {
        echo 'The event handler has pre events.<br />' . PHP_EOL;
    }

    if ($events->hasPost()) {
        echo 'The event handler has post events.<br />' . PHP_EOL;
    }

    echo $events->getListener('something.pre.app.users') . '<br />' . PHP_EOL;

    print_r($events->getListenersByPrefix('dispatch'));
    print_r($events->getListenersBySuffix('.app.users'));

    echo PHP_EOL . PHP_EOL;
} catch (\Exception $e) {
    echo $e->getMessage();
}

