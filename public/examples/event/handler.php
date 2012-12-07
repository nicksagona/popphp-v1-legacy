<?php

require_once '../../bootstrap.php';

use Pop\Event\Handler;

try {
    $events = new Handler('dispatch.pre', function($view) { echo 'This is a global pre event.'; });
    $events->attach('render.post', 'This is a global post event.')
           ->attach('blah.pre.', 'This is a route / pre event.')
           ->attach('another.post.app', 'This is a route /app/ post event.')
           ->attach('something.pre.app.users', 'This is a route /app/users pre event.');

    print_r($events);

    echo '<br />' . PHP_EOL;

    if ($events->hasGlobal('pre')) {
        echo 'The event handler has global pre events.<br />' . PHP_EOL;
    }

    if ($events->hasGlobal('post')) {
        echo 'The event handler has global post events.<br />' . PHP_EOL;
    }

    if ($events->hasRoutes('pre')) {
        echo 'The event handler has route pre events.<br />' . PHP_EOL;
    }

    if ($events->hasRoutes('post')) {
        echo 'The event handler has route post events.<br />' . PHP_EOL;
    }

    echo $events->getListener('something.pre.app.users') . '<br />' . PHP_EOL;

    echo PHP_EOL . PHP_EOL;
} catch (\Exception $e) {
    echo $e->getMessage();
}

