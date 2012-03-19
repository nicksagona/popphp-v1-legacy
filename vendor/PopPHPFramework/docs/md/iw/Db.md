Pop PHP Framework
=================

Documentation : Db
------------------

מרכיב Db מספק גישה למאגרי מידע מנורמל השאילתה. מתאמי הנתמכים הם:


* mysql
* mysqli
* pdo
* pgsql
* sqlite

דוחות מוכנים נתמכים עם Mysqli, PDO, Pgsql ו adapaters SQLite. ערכים נמלטים זמינים עבור כל המתאמים את.


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

בנוסף גישה למסדי נתונים, המרכיב Db גם תכונות אובייקט מופשט Sql שימושי המסייע לך ליצור שאילתות SQL סטנדרטי.


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
