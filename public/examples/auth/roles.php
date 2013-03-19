<?php

require_once '../../bootstrap.php';

use Pop\Auth\Role;

try {
    // Create some roles with permissions
    $reader = Role::factory('reader')->addPermission('read');
    $editor = Role::factory('editor')->addPermission('edit');
    $publisher = Role::factory('publisher')->addPermission('publish');
    $admin = Role::factory('admin')->addPermission('admin');

    // Add roles as child roles to demonstrate inheritance
    $reader->addChild(
        $editor->addChild(
            $publisher->addChild($admin)
        )
    );

    // Editor can read and edit, but not publish
    echo ($editor->hasPermission('publish')) ? 'Yes' : 'No';
} catch (\Exception $e) {
    echo $e->getMessage() . PHP_EOL . PHP_EOL;
}
