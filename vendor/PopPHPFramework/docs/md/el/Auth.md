Pop PHP Framework
=================

Documentation : Auth
--------------------

Home

Το συστατικό Auth διευκολύνει την πιστοποίηση και την αδειοδότηση των
χρηστών με βάση ένα βασικό σύνολο των εντολών και καθορισμένους ρόλους.
Η πτυχή της ταυτότητας χειρίζεται τον έλεγχο ταυτότητας ενός χρήστη για
να καθοριστεί εάν ή όχι ο χρήστης επιτρέπεται καθόλου. Το θέμα
χειρίζεται άδεια να καθοριστεί εάν ή όχι η γνησιότητα χρήστης έχει
πρόσβαση σε αρκετή να επιτρέπεται σε μια συγκεκριμένη περιοχή. Οι ρόλοι
μπορούν εύκολα να καθοριστούν και να αξιολογηθούν για να καθορίσει το
επίπεδο ενός χρήστη από την πρόσβαση. Το συστατικό Auth μπορεί εύκολα να
δέσει σε έναν πίνακα βάσης δεδομένων ή ένα αρχείο στο δίσκο για να
ανακτήσετε τα διαπιστευτήρια χρήστη και πληροφορίες.

    use Pop\Auth;

    // Set the username and password
    $username = 'testuser1';
    $password = '12test34';

    // Create auth object
    $auth = new Auth\Auth(
        new Auth\Adapter\File('../assets/files/access-sha1.txt'),
        Auth\Auth::ENCRYPT_SHA1
    );

    // Define some other auth parameters and authenticate the user
    $auth->setAttemptLimit(3)
         ->setAttempts(2)
         ->setAllowedIps('127.0.0.1')
         ->authenticate($username, $password);

    echo $auth->getResultMessage() . '<br /> ' . PHP_EOL;

    // Check if the auth attempt is valid
    if ($auth->isValid()) {
        // The user is valid so do top-secret stuff
    }


    $admin = Auth\Role::factory('admin', 4);
    $editor = Auth\Role::factory('editor', 3);
    $reader = Auth\Role::factory('reader', 2);
    $restricted = Auth\Role::factory('restricted', 1);

    $userRole = $editor;

    $acl = Auth\Acl::factory(array($admin, $editor, $reader));
    $acl->setRequiredRole('reader');

    echo '<h3>Reader Area</h3>' . PHP_EOL;
    echo 'The user is ' . ((!$acl->isAuthorized($userRole)) ? 'NOT ' : null) . 'authorized in the reader area.' . PHP_EOL;

    $acl->setRequiredRole('editor');

    echo '<h3>Editor Area</h3>' . PHP_EOL;
    echo 'The user is ' . ((!$acl->isAuthorized($userRole)) ? 'NOT ' : null) . 'authorized in the editor area.' . PHP_EOL;

    $acl->setRequiredRole('admin');

    echo '<h3>Admin Area</h3>' . PHP_EOL;
    echo 'The user is ' . ((!$acl->isAuthorized($userRole)) ? 'NOT ' : null) . 'authorized in the admin area.' . PHP_EOL;

\(c) 2009-2013 [Moc 10 Media, LLC.](http://www.moc10media.com) All
Rights Reserved.
