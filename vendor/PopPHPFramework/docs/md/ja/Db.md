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

    use Pop\Db\Db;
    use Pop\Db\Sql;

    $db = Db::factory('Sqlite', array('database' => 'mydb.sqlite'));

    $sql = new Sql($db, 'users');
    $sql->select()
        ->where()->equalTo('id', 1);

    // Outputs 'SELECT * FROM `users` WHERE `id` = 1'
    echo $sql;

としてドキュメント概要を説明してRecordクラスは、Active Recordは、表ゲートウェイパターン間一種の "ハイブリッド"です。標準化されたAPIを介して、それがデータベースのテーブル、または、一度に複数の行またはレコード内で単一の行またはレコードへのアクセスを提供することができます。最も一般的なアプローチは、データベース内のテーブルを表すRecordクラスを拡張子クラスを記述することです。子クラスの名前は、表の名前でなければなりません。 ：簡単に作成することにより、

    use Pop\Db\Record;

    class Users extends Record { }

あなたは、で、そのクラスがクラス名から照会するデータベーステーブルの名前を知って構築されたレコード·クラスのすべての機能を持つクラスを作成します。例えば、そこから`db_users`（キャメルケースが自動的lower_case_underscoreに変換されます。）に`ユーザ`や 'DbUsers'変換中に"ユーザー"変換は、次のような様々なクラスのプロパティを使用してテーブルを表す子クラスを微調整することができます：

    // Table prefix, if applicable
    protected $prefix = null;

    // Primary ID, if applicable, defaults to 'id'
    protected $primaryId = 'id';

    // Whether the table is auto-incrementing or not
    protected $auto = true;

    // Whether to use prepared statements or not, defaults to true
    protected $usePrepared = true;

使用して、定義済みのデータベースアダプタを持って構造化されたプロジェクト内にいる場合は、Recordクラスはそれを拾うと、それを使用します。あなたは、単にレコード·コンポーネントを使用して、いくつかの簡単なスクリプトを書いている場合は、その後に、使用するデータベース·アダプタのことを教えてやる必要があります：

    // Define DB credentials
    $creds = array(
        'database' => 'helloworld',
        'host'     => 'localhost',
        'username' => 'hello',
        'password' => '12world34'
    );

    // Create DB object
    $db = \Pop\Db\Db::factory('Mysqli', $creds);

    Record::setDb($db);

次のようにそこから、基本的な使い方は次のとおりです。

    // Get a single user
    $user = Users::findById(1001);
    echo $user->name;
    echo $user->email;

    // Get multiple users
    $users = Users::findAll('last_name ASC');
    foreach ($users->rows as $user) {
        echo $user->name;
        echo $user->email;
    }

\(c) 2009-2014 [Moc 10 Media, LLC.](http://www.moc10media.com) All
Rights Reserved.
