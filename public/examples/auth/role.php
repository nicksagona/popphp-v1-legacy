<?php

require_once '../../bootstrap.php';

use Pop\Auth\Role;

// Create two roles
$editor = Role::factory('editor', 5);
$reader = Role::factory('reader', 1);

// Compare the roles
if ($editor->compare($reader) > 0) {
    echo 'The ' . $editor . ' has a greater privilege level (' .
        $editor->getLevel() . ') than the ' . $reader . ' (' .
        $reader->getLevel() . ').';
} else {
    echo 'The ' . $editor . ' has a less privilege level (' .
        $editor->getLevel() . ') than the ' . $reader . ' (' .
        $reader->getLevel() . ').';
}

echo  PHP_EOL . PHP_EOL;

?>