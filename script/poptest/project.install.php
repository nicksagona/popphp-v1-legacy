<?php

return new Pop\Config(array(
    'project' => array(
        'name'    => 'HelloWorld',
        'base'    => __DIR__ . '/../../helloworld',
        'docroot' => __DIR__ . '/../../helloworld/public'
    ),
    'databases' => array(
        'poptest' => array(
            'type'     => 'Mysqli',
            'database' => 'poptest',
            'host'     => 'localhost',
            'username' => 'popuser',
            'password' => '12pop34'
        )
    ),
    'controller' => array(
        'index' => 'index.phtml',
        'about' => 'about.phtml',
        'error' => 'error.phtml'
    )
));