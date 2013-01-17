Pop PHP Framework
=================

Documentation : Auth
--------------------

المكون تسهل المصادقة مصادقة وترخيص من المستخدمين استنادا إلى مجموعة أساسية من وثائق التفويض وتحديد الأدوار. الجانب المصادقة يعالج مصادقة مستخدم لتحديد ما إذا كان أو لم يتم السماح لذلك المستخدم على الإطلاق. الجانب ترخيص يعالج تحديد ما إذا كانت مصادقة المستخدم لديه حق الوصول بما فيه الكفاية ليسمح ضمن منطقة معينة. ويمكن بسهولة أن تحدد الأدوار وتقييمها لتحديد مستوى المستخدم من الوصول. لا يمكن للعنصر المصادقة التعادل بسهولة في جدول قاعدة بيانات أو ملف على القرص لاسترداد أوراق اعتماد المستخدم والمعلومات.

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
