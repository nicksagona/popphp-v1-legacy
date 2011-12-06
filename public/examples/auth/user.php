<?php

require_once '../../bootstrap.php';

use Pop\Auth\Role,
    Pop\Auth\User;

// Define the roles and their levels
$editor = Role::factory('editor', 5);
$reader = Role::factory('reader', 1);

// Create the user and set his role
$user = new User('John', '12john34', $editor);

// Test if the user is authorized
if ($user->isAuthorized($reader)) {
    echo 'The user "' . $user->getUsername() .
        '" is authorized in this area because the user has the authorization level of an ' .
        $editor . ' (' . $editor->getLevel() .').';
} else {
    echo 'The user "' . $user->getUsername() .
        '" is NOT authorized in this area because the user only has the authorization level of a ' .
        $reader . ' (' . $reader->getLevel() .').';
}

echo  PHP_EOL . PHP_EOL;

?>