Pop PHP Framework
=================

Documentation : Db
------------------

Home

المكون ديسيبل يوفر الوصول إلى قواعد البيانات تطبيع الاستعلام. محولات
المعتمدة هي:

-   mysql
-   mysqli
-   oracle
-   pdo
-   pgsql
-   sqlite
-   sqlsrv

يتم اعتماد البيانات المعدة مع MySQLi، أوراكل، شركة تنمية نفط عمان،
الإنترنت، سكليتي ومحولات SQLSrv. القيم هرب متاحة لجميع المحولات.

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
    $db->adapter()->query('SELECT * FROM users');

    // Fetch the results
    while (($row = $db->adapter()->fetch()) != false) {
        print_r($row);
    }

بالإضافة إلى الوصول إلى قاعدة البيانات، المكون ديسيبل كما تحتوي على
التجريد مزود مفيدة الكائن الذي يساعدك في إنشاء استعلامات SQL موحدة.

    use Pop\Db\Sql;

    $sql = new Sql('users');
    $sql->setIdQuoteType(Sql::BACKTICK)
        ->select()
        ->where('id', '=', 1);

    // Outputs 'SELECT * FROM `users` WHERE `id` = 1'
    echo $sql;

\(c) 2009-2013 [Moc 10 Media, LLC.](http://www.moc10media.com) All
Rights Reserved.
