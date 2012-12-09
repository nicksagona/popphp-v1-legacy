<?php

require_once '../../bootstrap.php';

use Pop\Event\Handler,
    Pop\Project\Project;

try {
    $project = new Project();
    $project->attachEvent('greeting', function ($name) { $str = 'Hello, ' . $name; echo $str . '<br />' . PHP_EOL; return $str; }, 2)
            ->attachEvent('reply', function ($result) { echo 'You said, "' . $result . '"<br />' . PHP_EOL; }, 1)
            ->attachEvent('log', function () { echo 'Let\'s log it.<br />' . PHP_EOL; }, -1);

    $project->run(array('name' => 'World!'));
} catch (\Exception $e) {
    echo $e->getMessage();
}

