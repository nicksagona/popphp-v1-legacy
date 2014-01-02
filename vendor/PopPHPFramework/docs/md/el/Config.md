Pop PHP Framework
=================

Documentation : Config
----------------------

Home

Η Config συστατικό παρέχει ένα αντικείμενο τιμή δεδομένων που
χρησιμοποιείται από άλλα συστατικά όπως το συστατικό έργου. Συνήθως, τα
πράγματα όπως τα διαπιστευτήρια της βάσης δεδομένων που ορίζονται σε ένα
αντικείμενο ρυθμίσεων και να περάσει σε ένα αντικείμενο του έργου που
πρόκειται να χρησιμοποιηθούν κατά τη διάρκεια του κύκλου ζωής του έργου
ή σενάριο.

    use Pop\Config;

    $cfg = array(
        'db' => array(
            'name' => 'testdb',
            'host' => 'localhost',
            'user' => array(
                'username' => 'testuser',
                'password' => '12test34',
                'role'     => 'editor'
            )
        ),
        'module' => 'TestModule'
    );

    $config = new Config($cfg);

    echo 'DB Name: ' . $config->db->name;
    echo 'User: ' . $config->db->user->username . ' has the role: ' . $config->db->user->role;
    echo 'Module Name: ' . $config->module;

\(c) 2009-2014 [Moc 10 Media, LLC.](http://www.moc10media.com) All
Rights Reserved.
