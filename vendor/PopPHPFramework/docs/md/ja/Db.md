Pop PHP Framework
=================

Documentation : Db
------------------

Home

DBコンポーネントは、クエリのデータベースへの正規化されたアクセスを提供します。サポートされているアダプタは以下のとおりです。

-   mysql
-   mysqli
-   oracle
-   pdo
-   pgsql
-   sqlite
-   sqlsrv

プリペアドステートメントはMySQLiのは、Oracle、PDOは、PostgreSQL、SQLiteとSQLSRVアダプタでサポートされています。エスケープされた値は、すべてのアダプターをご利用いただけます。

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

データベースへのアクセスに加えて、DBコンポーネントも標準化されたSQLクエリの作成を支援する便利なSQLの抽象化オブジェクトを提供しています。

    use Pop\Db\Sql;

    $sql = new Sql('users');
    $sql->setIdQuoteType(Sql::BACKTICK)
        ->select()
        ->where('id', '=', 1);

    // Outputs 'SELECT * FROM `users` WHERE `id` = 1'
    echo $sql;

\(c) 2009-2013 [Moc 10 Media, LLC.](http://www.moc10media.com) All
Rights Reserved.
