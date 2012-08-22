Pop PHP Framework
=================

Documentation : Db
------------------

المكون ديسيبل يوفر الوصول إلى قواعد البيانات تطبيع الاستعلام. المحولات المعتمدة هي:

* sqlsrv
* mysql
* mysqli
* oracle
* pdo
* pgsql
* sqlite

يتم اعتماد البيانات المعدة مع SQLSrv)، MySQLi، أوراكل، وشركة تنمية نفط عمان، وكيو adapaters سكليتي. قيم هرب متاحة للجميع من المحولات.

<pre>
use Pop\Db\Db;

// Define DB credentials
$creds = array(
    'database' => 'helloworld',
    'host'     => 'localhost',
    'username' => 'hello',
    'password' => '12world34'
);

// Create DB object
$db = Db::factory('Mysqli', $creds);

// Perform the query
$db->adapter->query('SELECT * FROM users');

// Fetch the results
while (($row = $db->adapter->fetch()) != false) {
    print_r($row);
}
</pre>

بالإضافة إلى الوصول إلى قاعدة البيانات، المكون ديسيبل كما تحتوي على التجريد مزود مفيد الكائن الذي يساعدك في إنشاء استعلامات SQL موحدة.

<pre>
use Pop\Db\Sql;

$sql = new Sql('users');
$sql->setIdQuoteType(Sql::BACKTICK)
    ->select()
    ->where('id', '=', 1);

// Outputs 'SELECT * FROM `users` WHERE `id` = 1'
echo $sql;
</pre>

(c) 2009-2012 [Moc 10 Media, LLC.](http://www.moc10media.com) All Rights Reserved.
