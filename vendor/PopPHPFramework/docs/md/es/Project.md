Pop PHP Framework
=================

Documentation : Project
-----------------------

Home

El componente del proyecto contiene la clase de proyecto en el que se
puede extender y encapsular las especificaciones de la aplicaciÃ³n, como
el router, controladores, bases de datos y los mÃ³dulos. Una vez
configurado correctamente, el proyecto puede "correr" con Ã©xito y
enrutar la solicitud del usuario para el Ã¡rea correcta de la
aplicaciÃ³n. Ver el Componente Mvc doc para ver un ejemplo de un archivo
de proyecto de clase extendida.

AdemÃ¡s, el componente del proyecto contiene las clases que el
componente de instalaciÃ³n CLI utiliza para construir e instalar el
andamio proyecto. Un ejemplo de un archivo de configuraciÃ³n del
proyecto de instalaciÃ³n estÃ¡ por debajo.

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

\(c) 2009-2013 [Moc 10 Media, LLC.](http://www.moc10media.com) All
Rights Reserved.
