Pop PHP Framework
=================

Documentation : Project
-----------------------

Home

Η συνιστώσα του σχεδίου περιλαμβάνει την κατηγορία έργου, στο οποίο
μπορείτε να επεκτείνετε και να ενσωματώσουν τις προδιαγραφές της
εφαρμογής σας, όπως το router, ελεγκτές, βάσεις δεδομένων και μονάδες.
Μόλις, ρυθμιστεί σωστά, το έργο μπορεί να "τρέξει" με επιτυχία και
δρομολογούν αίτημα του χρήστη για τη σωστή περιοχή της αίτησής σας.
Δείτε το Component MVC αρχείο doc για να δείτε ένα παράδειγμα μιας
εκτεταμένης αρχείο κατηγορία έργου.

Επίσης, η συνιστώσα του σχεδίου περιλαμβάνει τις τάξεις εγκατάσταση ότι
η συνιστώσα CLI χρησιμοποιεί για την κατασκευή και εγκατάσταση σκαλωσιές
έργο σας. Ένα παράδειγμα αρχείου ρυθμίσεων εγκατάστασης του έργου είναι
κάτω.

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
