<?php

require_once '../../bootstrap.php';

use Pop\Project\Project;

try {

    $project = new Project();
    $project->setService('config', 'Pop\Config', array(array('test' => 123)))
            ->setService('color', 'Pop\Color\Color', function() {
                return array(new \Pop\Color\Rgb(255, 0, 0));
            });
    print_r($project);
    print_r($project->getService('config'));
    print_r($project->getService('color'));
    print_r($project);
} catch (\Exception $e) {
    echo $e->getMessage() . PHP_EOL . PHP_EOL;
}
