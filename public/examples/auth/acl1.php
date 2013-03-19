<?php

require_once '../../bootstrap.php';

use Pop\Auth\Role;

try {
    $reader = Role::factory('reader')->addPermission('read');
    $editor = Role::factory('editor')->addPermission('edit');
    $publisher = Role::factory('publisher')->addPermission('publish');
    $admin = Role::factory('admin')->addPermission('admin');

    $publisher->addChild($admin);
    $editor->addChild($publisher);
    $reader->addChild($editor);

    echo ($editor->hasPermission('publish')) ? 'Yes' : 'No';
} catch (\Exception $e) {
    echo $e->getMessage() . PHP_EOL . PHP_EOL;
}
