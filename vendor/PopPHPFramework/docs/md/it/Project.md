Pop PHP Framework
=================

Documentation : Project
-----------------------

Il componente del progetto contiene la classe di progetto in cui è possibile estendere e incapsulare le specifiche della vostra applicazione, come il router, i controller, database e moduli. Una volta impostato correttamente, il progetto può "correre" e il sentiero con successo la richiesta dell'utente per l'area corretta dell'applicazione. Visualizzare il componente Mvc doc file per vedere un esempio di un file di estensione della classe Project.


Inoltre, il componente del progetto di installazione contiene le classi che la componente CLI utilizza per costruire e installare il ponteggio progetto. Un esempio di un file di configurazione del progetto di installazione è inferiore.


<pre>
&lt;?php
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
        'default' => array(
            'index' => 'index.phtml',
            'error' => 'error.phtml'
        ),
        'admin' => array(
            'index' => 'index.phtml',
            'error' => 'error.phtml'
        )
    )
));
</pre>

(c) 2009-2012 [Moc 10 Media, LLC.](http://www.moc10media.com) All Rights Reserved.
