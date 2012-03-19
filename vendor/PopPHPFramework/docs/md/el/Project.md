Pop PHP Framework
=================

Documentation : Project
-----------------------

Η συνιστώσα του σχεδίου περιλαμβάνει την κατηγορία έργου, στο οποίο μπορείτε να επεκτείνετε και να ενσωματώσει τις προδιαγραφές της εφαρμογής σας, όπως το router, ελεγκτές, βάσεων δεδομένων και λειτουργικών μονάδων. Μόλις, που έχει συσταθεί σωστά, το έργο μπορεί να "τρέξει" με επιτυχία και δρομολογούν αίτημα του χρήστη για τη σωστή περιοχή της αίτησής σας. Δείτε το Στοιχείο MVC αρχείο doc για να δείτε ένα παράδειγμα μιας εκτεταμένης κατηγορίας αρχείο έργου.

Επίσης, η συνιστώσα του σχεδίου περιλαμβάνει τις κατηγορίες ότι η εγκατάσταση του στοιχείου CLI χρησιμοποιεί για να κατασκευάσει και εγκαταστήσει σκαλωσιές έργο σας. Ένα παράδειγμα αρχείου ρυθμίσεων εγκατάστασης του έργου είναι η παρακάτω.

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
