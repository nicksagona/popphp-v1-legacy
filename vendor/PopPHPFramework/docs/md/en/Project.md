Pop PHP Framework
=================

Documentation : Project
-----------------------

Home

The Project component contains the Project class in which you can extend
and encapsulate your application's specifications, such as the router,
controllers, databases and modules. Once, set up properly, the project
can "run" and successfully route the user's request to the correct area
of your application. View the Mvc Component doc file to see an example
of an extended Project class file.

Also, the Project component contains the install classes that the CLI
component uses to build and install your project scaffolding. An example
of a project install configuration file is below.

    <?php
    return new Pop\Config(array(
        'project' => array(
            'name'    => 'HelloWorld',
            'base'    => __DIR__ . '/../../',
            'docroot' => __DIR__ . '/../../public'
        ),
        'databases' => array(
            'helloworld' => array(
                'type'     => 'Mysqli',
                'database' => 'helloworld',
                'host'     => 'localhost',
                'username' => 'hello',
                'password' => '12world34',
                'prefix'   => 'pop_',
                'default'  => true
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
                        'type'       => 'password',
                        'name'       => 'password',
                        'label'      => 'Password:',
                        'required'   => true,
                        'attributes' => array('size', 40),
                        'validators' => array('NotEmpty()', 'LengthGt(6)')
                    ),
                    array(
                        'type'       => 'submit',
                        'name'       => 'submit',
                        'value'      => 'LOGIN'
                    )
                )
            )
        ),
        'controllers' => array(
            '/' => array(
                'index' => 'index.phtml',
                'error' => 'error.phtml'
            ),
            '/admin' => array(
                'index' => 'index.phtml',
                'error' => 'error.phtml'
            )
        )
    ));

\(c) 2009-2014 [Moc 10 Media, LLC.](http://www.moc10media.com) All
Rights Reserved.
