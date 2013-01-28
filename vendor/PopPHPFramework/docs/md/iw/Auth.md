Pop PHP Framework
=================

Documentation : Auth
--------------------

Home

רכיב האימות מאפשר אימות ואישור של משתמשים על סמך ערכה בסיסית של אישורים
ותפקידים מוגדרים. היבט האימות מטפל אימות משתמש כדי לקבוע אם או לא
שהמשתמש רשאי בכלל. היבט ההרשאה מטפל קביעה אם המשתמש המורשה יש מספיק לגשת
ליתאפשר בתוך אזור מסוים. תפקידים יכולים בקלות להיות מוגדרים וייבדקו כדי
לקבוע הרמה של משתמש של גישה. מרכיב האימות בקלות יכול לקשור לטבלת מסד
נתונים או קובץ בדיסק כדי לאחזר אישורי משתמש ומידע.

    use Pop\Auth;

    // Set the username and password
    $username = 'testuser3';
    $password = '90test12';

    // Create auth object
    $auth = new Auth\Auth(new Auth\Adapter\File('../assets/files/access.txt'), Auth\Auth::ENCRYPT_SHA1);

    // Add some roles
    $auth->addRoles(array(
        Auth\Role::factory('admin', 3),
        Auth\Role::factory('editor', 2),
        Auth\Role::factory('reader', 1)
    ));

    // Define some other auth parameters and authenticate the user
    $auth->setRequiredRole('admin')
         ->setAttemptLimit(3)
         ->setAllowedIps('127.0.0.1')
         ->authenticate($username, $password);

    echo $auth->getResultMessage() . '<br /> ' . PHP_EOL;

    // Check if the user is authorized to be in this area
    if ($auth->isValid()) {
        if ($auth->isAuthorized()) {
            echo 'The user "' . $auth->getUser()->getUsername() .
                 '" is authorized as a "' .  $auth->getUser()->getRole()->getName() . '".';
        } else {
            echo 'The user "' . $auth->getUser()->getUsername() .
                 '" is NOT authorized. The user is a "' .  $auth->getUser()->getRole()->getName() .
                 '" and needs to be a "' . $auth->getRequiredRole()->getName() . '".';
        }
    }

\(c) 2009-2013 [Moc 10 Media, LLC.](http://www.moc10media.com) All
Rights Reserved.
