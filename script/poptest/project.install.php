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
            'password' => '12pop34',
            'prefix'   => 'pop_'
        )
    ),
    'forms' => array(
        'login' => array(
            'fields' => array(
                array(
                    'type'       => 'text',
                    'name'       => 'username',
                    'label'      => 'Username:',
                    'required'   => true,
                    'attributes' => array('size', 40),
                    'validators' => 'AlphaNumeric()'
                ),
                array(
                    'type'       => 'text',
                    'name'       => 'email',
                    'label'      => 'Email:',
                    'required'   => true,
                    'attributes' => array('size', 40),
                    'validators' => array('NotEmpty()', 'Email()')
                ),
                array(
                    'type'       => 'password',
                    'name'       => 'password',
                    'label'      => 'Password:',
                    'required'   => true,
                    'attributes' => array('size', 40),
                    'validators' => 'LengthGt(6)'
                ),
                array(
                    'type'       => 'checkbox',
                    'name'       => 'colors',
                    'label'      => 'Colors:',
                    'value'      => array('Red' => 'Red', 'Green' => 'Green', 'Blue' => 'Blue')
                ),
                array(
                    'type'       => 'submit',
                    'name'       => 'submit',
                    'value'      => 'SUBMIT',
                    'attributes' => array('style', 'padding: 5px; border: solid 2px #000; background-color: #00f; color: #fff; font-weight: bold;')
                )
            )
        )
    ),
    'controllers' => array(
        'default' => array(
            'index' => 'index.phtml',
            'about' => 'about.phtml',
            'error' => 'error.phtml'
        )
    )
));