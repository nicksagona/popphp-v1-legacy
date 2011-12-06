<?php

require_once '../../bootstrap.php';

use Pop\Auth\Role;

// Create two roles
$editor = Role::factory('editor', 5);
$reader = Role::factory('reader', 1);

// Compare the roles
if ($editor->compare($reader) > 0) {
    echo 'The ' . $editor . ' has greater privilege than the ' . $reader . '.' . PHP_EOL;
} else {
    echo 'The ' . $editor . ' has less privilege than the ' . $reader . '.' . PHP_EOL;
}

echo 'Done.' . PHP_EOL . PHP_EOL;

?>