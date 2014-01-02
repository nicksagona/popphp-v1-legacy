Pop PHP Framework
=================

Documentation : Project
-----------------------

Home

La composante du projet comprend la classe de projet dans lequel vous
pouvez étendre et d'encapsuler les spécifications de votre application,
comme le routeur, les contrôleurs, les bases de données et les modules.
Une fois, correctement configuré, le projet peut "exécuter" et acheminer
avec succès demande de l'utilisateur à la zone correcte de votre
application. Voir le composant Mvc fichier doc pour voir un exemple d'un
fichier de classe au projet prorogé.

En outre, la composante du projet contient les classes d'installation
que la composante CLI utilise pour construire et installer votre
échafaudage projet. Un exemple de fichier de configuration du projet
d'installation est ci-dessous.

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
