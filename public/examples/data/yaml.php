<?php

require_once '../../bootstrap.php';

use Pop\Data\Type\Yaml;

try {
    $users = Yaml::decode(file_get_contents('../assets/files/test.yml'));
    print_r($users);

    echo '<br />' . PHP_EOL;

    $yamlStr = Yaml::encode($users);
    echo $yamlStr;
} catch (\Exception $e) {
    echo $e->getMessage();
}

