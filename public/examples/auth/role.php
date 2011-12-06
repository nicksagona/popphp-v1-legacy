<?php

require_once '../../bootstrap.php';

use Pop\Auth\Role;

$editor = Role::factory('editor', 5);
$reader = Role::factory('reader', 1);

if ($editor->compare($reader) > 0) {
    echo 'The ' . $editor . ' has greater privilege than the ' . $reader . '.<br />' . PHP_EOL;
} else {
    echo 'The ' . $editor . ' has less privilege than the ' . $reader . '.<br />' . PHP_EOL;
}

?>