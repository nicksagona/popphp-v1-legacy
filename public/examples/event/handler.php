<?php

require_once '../../bootstrap.php';

use Pop\Event\Handler;

try {
    $events = new Handler('dispatch', 'Test event 123.', 3);
    $events->attach('render', 'This is a pre-level event.', 2)
           ->attach('blahblah', 'This is a 2nd another pre event.', 2)
           ->attach('blah', 'This is another pre event.', 1)
           ->attach('another.*', 'This is a global 0 event.')
           ->attach('another.app', 'This is another 0 event.')
           ->attach('another.app.event', 'This is another 0 event, again.')
           ->attach('something.app.users', 'This is yet another post event.', -1)
           ->attach('something.app.users.add', 'This is yet another post event, again.', -1)
           ->attach('somethingelse.app.users.edit', 'This is one more post event.', -2);

    print_r($events);

    echo '<br />' . PHP_EOL;
    echo $events->get('something.pre.app.users') . '<br />' . PHP_EOL;
    echo $events->getPriority('something.pre.app.users') . '<br />' . PHP_EOL;

    $events->trigger($events, -1);

    echo PHP_EOL . PHP_EOL;
} catch (\Exception $e) {
    echo $e->getMessage();
}

