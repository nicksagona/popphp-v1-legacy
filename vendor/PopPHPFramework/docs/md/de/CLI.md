Pop PHP Framework
=================

Documentation : CLI
-------------------

Home

Die Kommandozeilen-Schnittstelle (CLI)-Komponente ist eine sehr
nützliche Komponente, die Sie durchführen einige hilfreiche Aufgaben wie
erlaubt:

-   Beurteilung der derzeitigen Rahmenbedingungen für erforderlichen
    Abhängigkeiten
-   Installieren Sie ein Projekt aus einem Projekt Installationsdatei
-   die Standardsprache einer Anwendung
-   Erstellen Sie eine Klasse map
-   überprüfen Sie die aktuelle Version mit der neuesten verfügbaren
    Version

<!-- -->

    script/pop --check                     // Check the current configuration for required dependencies
    script/pop --help                      // Display this help
    script/pop --install file.php          // Install a project based on the install file specified
    script/pop --lang fr                   // Set the default language for the project
    script/pop --map folder file.php       // Create a class map file from the source folder and save to the output file
    script/pop --show                      // Show project install instructions
    script/pop --version                   // Display version of Pop PHP Framework and latest available

Hier ist ein Beispiel-Projekt Installationsdatei:

    return new Pop\Config(array(
        'project' => array(
            'name'    => 'HelloWorld',
            'base'    => __DIR__ . '/../../',
            'docroot' => __DIR__ . '/../../public'
        ),
        'databases' => array(
            'helloworld' => array(
                'type'     => 'Sqlite',
                'database' => '.hthelloworld.sqlite',
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
                'index'   => 'index.phtml',
                'about'   => 'about.phtml',
                'contact' => 'contact.phtml',
                'error'   => 'error.phtml'
            )
        ),
        'models' => array(
            'User'
        )
    ));

\(c) 2009-2014 [Moc 10 Media, LLC.](http://www.moc10media.com) All
Rights Reserved.
