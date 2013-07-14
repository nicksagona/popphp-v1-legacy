<?php

require_once '../../bootstrap.php';

use Pop\Auth;
use Pop\Nav\Nav;

try {
    $page = new Auth\Resource('page');
    $user = new Auth\Resource('user');

    $basic = Auth\Role::factory('basic')->addPermission('add');
    $editor = Auth\Role::factory('editor')->addPermission('add')
                                          ->addPermission('edit');

    $acl = new Auth\Acl();
    $acl->addRoles(array($basic, $editor));
    $acl->addResources(array($page, $user));

    $acl->allow('basic', 'page', array('add'))
        ->allow('editor', 'page')
        ->allow('editor', 'user');

    $tree = array(
        array(
            'name'     => 'Pages',
            'href'     => '/pages',
            'children' => array(
                array(
                    'name' => 'Add Page',
                    'href' => 'add',
                    'acl'  => array(
                        'resource'   => 'page',
                        'permission' => 'add'
                    )
                ),
                array(
                    'name' => 'Edit Page',
                    'href' => 'edit',
                    'acl'  => array(
                        'resource'   => 'page',
                        'permission' => 'edit'
                    )
                )
            )
        ),
        array(
            'name'     => 'Users',
            'href'     => '/users',
            'acl'  => array(
                'resource'   => 'user'
            ),
            'children' => array(
                array(
                    'name' => 'Add User',
                    'href' => 'add'
                ),
                array(
                    'name' => 'Edit User',
                    'href' => 'edit'
                )
            )
        )
    );

    $config = array(
        'top' => array(
            'id'    => 'main-nav'
        )
    );

    $nav = new Nav($tree, $config);
    $nav->setAcl($acl)
        ->setRole($editor);

    echo $nav;

} catch (\Exception $e) {
    echo $e->getMessage();
}

