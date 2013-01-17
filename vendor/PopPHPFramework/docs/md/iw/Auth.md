Pop PHP Framework
=================

Documentation : Auth
--------------------

רכיב המחבר מאפשר אימות ואישור של משתמשים בהתבסס על מערכת בסיסית של אישורי ותפקידים מוגדרים. היבט אימות מטפל אימות המשתמש כדי לקבוע אם שהמשתמש מותר בכלל. היבט אישור מטפל לקבוע אם משתמש מאומת יש מספיק גישה יורשו בתחום מסוים. תפקידים יכול בקלות להיות מוגדר הערכה כדי לקבוע את רמת המשתמש של גישה. רכיב המחבר יכול בקלות לקשור לטבלה מסד נתונים או קבצים על הדיסק כדי לאחזר אישורי המשתמש ומידע.

<pre>
use Pop\Auth\Auth,
    Pop\Auth\Role,
    Pop\Auth\Adapter\AuthFile,
    Pop\Auth\Adapter\AuthTable;

// Create the Auth object using a table in the database or a local access file.
$auth = new Auth(new AuthTable('MyApp\\Table\\Users'), Auth::ENCRYPT_SHA1);
//$auth = new Auth(new AuthFile('../access/users.txt'), Auth::ENCRYPT_SHA1);

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

(c) 2009-2013 [Moc 10 Media, LLC.](http://www.moc10media.com) All Rights Reserved.
