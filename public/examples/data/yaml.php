<?php

require_once '../../bootstrap.php';

use Pop\Data\Yaml,
    Pop\File\File;

try {
    $yaml = new File('../assets/files/test.yml');
    $users = Yaml::decode($yaml->read());
    print_r($users);

    echo '<br />' . PHP_EOL;

    $yamlStr = Yaml::encode($users);
    echo $yamlStr;
} catch (\Exception $e) {
    echo $e->getMessage();
}

?>