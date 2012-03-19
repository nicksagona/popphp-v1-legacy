Pop PHP Framework
=================

Documentation : Auth
--------------------

Το συστατικό Auth διευκολύνει την επαλήθευση ταυτότητας και αδειοδότηση των χρηστών με βάση ένα βασικό σύνολο των εντολών και καθορισμένους ρόλους. Η πτυχή της ταυτότητας χειρίζεται την επικύρωση του χρήστη να καθορίσει το κατά πόσον ή όχι αυτός ο χρήστης επιτρέπεται καθόλου. Η πτυχή άδεια χειρίζεται διαπιστωθεί κατά πόσον ή όχι ο εξουσιοδοτημένος χρήστης έχει πρόσβαση σε αρκετό να επιτρέπεται σε μια ορισμένη περιοχή. Οι ρόλοι μπορούν εύκολα να οριστούν και να αξιολογούνται ώστε να καθοριστεί το επίπεδο ενός χρήστη για πρόσβαση. Το συστατικό Auth μπορεί εύκολα να δέσουν σε μια βάση δεδομένων ή ένα αρχείο στο δίσκο για να ανακτήσετε τα διαπιστευτήρια των χρηστών και των πληροφοριών.


<pre>
use Pop\Auth\Auth,
    Pop\Auth\Role,
    Pop\Auth\Adapter\AuthFile,
    Pop\Auth\Adapter\AuthTable;

// Create the Auth object using a table in the database or a local access file.
$auth = new Auth(new AuthTable('MyApp\\Table\\Users'), 0, Auth::ENCRYPT_SHA1);
//$auth = new Auth(new AuthFile('../access/users.txt'), 0, Auth::ENCRYPT_SHA1);

// Add some roles
$auth->addRoles(array(
    Role::factory('admin', 3),
    Role::factory('editor', 2),
    Role::factory('reader', 1)
));

// Define some other auth parameters and authenticate the user
$auth->setRequiredRole('admin')
     ->setAttemptLimit(3)
     ->setAllowedIps('127.0.0.1')
     ->authenticate($username, $password);

// Check if the user is authorized to be in this area
if ($auth->isValid()) {
    if ($auth->isAuthorized()) {
        echo 'The user is authorized in this area.';
    } else {
        echo 'The user is NOT authorized in this area.';
    }
} else {
    echo 'Authenication failed. The user is not valid. ' . $auth->getResultMessage();
}
</pre>

(c) 2009-2012 [Moc 10 Media, LLC.](http://www.moc10media.com) All Rights Reserved.
