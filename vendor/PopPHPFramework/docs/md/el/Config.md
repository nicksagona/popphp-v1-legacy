Pop PHP Framework
=================

Documentation : Config
----------------------

Το Config στοιχείο παρέχει ένα αντικείμενο αξίας δεδομένων που χρησιμοποιείται από τις άλλες συνιστώσες, όπως η συνιστώσα του σχεδίου. Συνήθως, τα πράγματα όπως τα διαπιστευτήρια βάση δεδομένων που ορίζονται σε ένα αντικείμενο ρυθμίσεων και να περάσει σε ένα αντικείμενο του έργου που πρόκειται να χρησιμοποιηθούν κατά τη διάρκεια του κύκλου ζωής του έργου ή σενάριο.


<pre>
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
</pre>

(c) 2009-2012 [Moc 10 Media, LLC.](http://www.moc10media.com) All Rights Reserved.
